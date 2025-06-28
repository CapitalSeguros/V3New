<?php
  	$this->load->view('capacita/menu_capacita'); 
?>

<section class="page-section">
	<div class="container">

		<div class="row">
        	<div class="col-sm-12 col-md-12">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#myCarousel" data-slide-to="1"></li>
							<li data-target="#myCarousel" data-slide-to="2"></li>
							<li data-target="#myCarousel" data-slide-to="3"></li>
						</ol>
					<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>

							<div class="item">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>

							<div class="item">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>

							<div class="item">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>
						</div>

					<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
				</div>
			</div>
        </div>
	</div>            
</section>

<!-- Ventana Modal de asignacion de capacitacion-->
<div class="modal capacitacion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="text-align: center">
        <h5>Asignación de capacitación</h5>
      </div> <!--[Dennis 2020-05-21 aquiSe]-->
      <div class="modal-body"  style="text-align: center">
        <select name="" id="opcionesCarga" class="custom-select mr-sm-2" style="font-size: 12px;" class="form-control">
          <option selected>Selecccione</option>
          <option value="1">Asignar horas de capacitación</option>
          <option value="2">Subir imágenes del curso</option>
        </select>
        <p id="prueba"></p>
        <form method="POST" name="capaForm" id="capaForm">
          <div style="display: none;" id="cargaHrs"><!--<p>carga de horas</p>-->
            <div><select id="selectCapacitacion" name="selectNameCapacitacion" required style="font-size: 12px;" class="form-control">
              <option value="">Seleccione un capacitación</option>
              <?php foreach($capacitacion as $valor){?>
                <option value=<?=$valor->id_capacitacion?>><?=ucwords($valor->tipoCapacitacion)?></option>
              <?php }?>
            </select>
            </div><br>
            <div id="contSelectCertificacion" style="display: none">
                <select name="nameSelectCerti" id="selectCerti" required style="font-size: 12px;" class="form-control"></select>
            </div>
            <br>
            <br>
            <div id="contHrsCert" style="display:none;">
              <table border="0" style="width: 100%font-size:16px;text-align: left;" >
                <tr>
                  <td>Hrs de Desarrollo Prof</td>
                  <td><input type="number" name="certificacion" id="certificacion" class="form-control"></td>
                  <td>Hrs Autos</td>
                  <td><input type="number" name="certificacionAutos" id="certificacionAutos" class="form-control"></td>
                  <td>Hrs Gastos Medicos</td>
                  <td><input type="number" name="certificacionGmm" id="certificacionGmm" class="form-control"></td>
                </tr>
                 <tr>
                  <td>Hrs de Vida</td>
                  <td><input type="number" name="certificacionVida" id="certificacionVida" class="form-control"></td>
                  <td>Hrs Daños</td>
                  <td><input type="number" name="certificacionDanos" id="certificacionDanos" class="form-control"></td>
                  <td>Hrs Fianzas</td>
                  <td><input type="number" name="certificacionFianzas" id="certificacionFianzas" class="form-control"></td>
                </tr>
                <tr>
                  <td>Descripcion de la capacitación</td>
                  <td colspan="5"><input type="text" name="descripcion" id="descripcion" class="form-control"></td>
                </tr>
              </table>
            </div>
          </div>
          
          <div style="display: none" id="cargaImg">
            <p>carga de imagenes</p>
            <input type="file" name="cargaImagen" id="cargaImagen" multiple >  
            
          </div><br>
          <div id="buscadorVendedores" style="width: 100%; text-align: left">
            <p>Buscar vendedor: </p>
            <!--<input type="text" name="buscaVendedor" id="buscaVendedor" style="height: 20px">-->
            <?php 
              $correos_validos=array("SISTEMAS@ASESORESCAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX","MARKETING@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM");
              if(in_array($this->tank_auth->get_usermail(),$correos_validos)) {?>
            
              <select name="cuentasACargo" id="cuentasACargo" onchange="enviaUsuario('this')" class="form-control input-sm"></select> 
            
            <?php }?> <!--[Dennis 2020-04-29]-->
          </div> <!--[Dennis 2020-04-27]-->

          <div id="listaCapa" style="overflow-y:scroll; height:200px;">
            <table style="width: 99%" id="tablaVendedores" class="table table-hover">
              <thead style="background-color:#472380; color:white;" id="cabeceraTabla"><tr><td>Seleccionar todo: <input type="checkbox" id="opcionTotal"></td><td>Nombre completo</td><td>Tipo de agente</td><td>Canal</td><td>Sucursal</td></tr></thead>
              <tbody style="border: solid 1px #D5D8DC" id="cuerpoTabla">
              <?php if(isset($agentesTemporales)){
                for($i=0;$i<count($agentesTemporales);$i++){?>
                <tr style="border-bottom-color:#D5D8DC; border-bottom-style: solid; border-bottom-width:1px" id="contenidoTabla">
                    <td  style="width: 15%"><input type="checkbox" class="opcionSelect" name="idPersona[]" value="<?=$agentesTemporales[$i]->idPersona?>"></td>
                    <td  style="text-align: left"><?=$agentesTemporales[$i]->nombres." ".$agentesTemporales[$i]->apellidoPaterno." ".$agentesTemporales[$i]->apellidoMaterno?></td>
                    <td><?=$agentesTemporales[$i]->personaTipoAgente?></td>
                    <td><?=$agentesTemporales[$i]->nombreTitulo?></td>
                    <td><?=$agentesTemporales[$i]->sucursal?></td> 
                </tr>
                <?php }} else{echo "No hay datos por el momento";}?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <!--<input type="submit" value="Enviar">-->
            <button class="btn btn-primary btn-md" id="actualizarCapa" style="display: none"><i class="fa fa-send"></i>Enviar</button>
            <button class="btn btn-primary btn-md" id="insertaImg" style="display: none"><i class="fa fa-send"></i>Enviar imagenes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--    fin  -->

<?php $this->load->view('footers/footer'); ?>

<script type="text/javascript">

<?php 

 if(isset($mensajePersona)){echo $mensajePersona;}  	 ?>


 <?php //[Dennis 2020-04-04]
 //Cuando cargué la página de alta de agentes, inicializa estas variables a cero para la funcion: function validadorArchivos().
  if(empty($obtenerArchivosObligatorios) && empty($datosAgente) && empty($docObligatorios)){
    $obtenerArchivosObligatorios=0;
    $datosAgente=0;
    $docObligatorios=0;
  }
  
  //var_dump($this->tank_auth->get_usermail());
  if(in_array($this->tank_auth->get_usermail(),$correos_validos)) {
    $options="";
    $option0="<option value=todos>Todos</option>";
    
    #foreach ($filtroCreacion as $key => $value) {$options=$options.'<option value="'.$key.'">'.$key.'</option>';}
    foreach ($coordinadores as  $value) {

      $options=$options.'<option value="'.$value->email.'">'.$value->email.'</option>';
    }
    //echo('document.getElementById(\'selectFiltroCreador\').innerHTML=\''.$options.'\';'); 
    //if($this->tank_auth->get_usermail()=="SISTEMAS@ASESORESCAPITAL.COM"){

      echo('document.getElementById(\'cuentasACargo\').innerHTML=\''.$option0.''.$options.'\';');
      //echo ("<select name='cuentasACargo' id='cuentasACargo'>".$options."</select>");
    //}//cuentasACargo //[Dennis 2020-04-29]
  }
 ?>


function direccionAJAX(opcion,id){

  var direccionAJAX="<?php echo(base_url().'persona/');?>";
  switch(opcion){
     case 'ventanaImagenes':direccionAJAX=direccionAJAX+'verImagenesPersona/?idPersona='+document.getElementById('idPersonas').value+"&tipoVentana=0"; break;
     case 'ventanaImagenPersonal':direccionAJAX=direccionAJAX+'verImagenesPersona/?idPersona='+document.getElementById('idPersonas').value+"&tipoVentana=1"; break;
    case 'borraImagenCurso':direccionAJAX=direccionAJAX+'verImagenesPersona/?idPersona='+document.getElementById('idPersonas').value+"&tipoVentana=2&idImagen="+id; document.getElementById("btnCerrarVentana").onclick(); break;
  } 

  conectaAJAX(direccionAJAX);
}

function conectaAJAX(direccionAJAX){
  var req = new XMLHttpRequest();
  req.open('GET',direccionAJAX, true);
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {
      if (document.getElementById("divVentanaImagenes")){document.body.removeChild(document.getElementById('divVentanaComentarios'));}
      if(document.getElementById("divVentanaImagenesEstilo")){document.head.removeChild(document.getElementById('divVentanaComentarioEstilo'));}
       var j=JSON.parse(this.responseText);
       var hoja = document.createElement('style');hoja.id="divVentanaImagenesEstilo";
       document.head.appendChild(hoja);                   
       var div=document.createElement('div');div.id="divVentanaImagenes";div.innerHTML=j["datos"];
       hoja.type="text/css";
       hoja.innerHTML=j['estilo'];
       document.body.appendChild(div);
       document.getElementById("divVentanaImagenes").classList.add('divVentanaImagenesEstilo');                                                     
      }     
   }
  };
 req.send();
}


</script>

<script type="text/javascript">
$(function () {$(".fechaPersona").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});



 function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

//-----------------------------------------------------------------------------
//[Dennis 2020-03-30]
function segmentarTipoAgente(){
  
  var idModalidad= $("#idModalidad").val();
  $.ajax({
    type:"POST",
    url:<?php echo('"'.base_url().'persona/obtieneTipoAgente"'); ?>,
    data:{"tipoModalidad":idModalidad},
    error: function(){},
    success: function(data){
      //$('#personaTipoAgente').html(data);
      $('#personaTipoAgente').html(`
      <option value=''>Seleccione</option>
      `+data);
    }
  });
}
//[Dennis 2020-04-14]
 $('#personaTipoAgente').on('change', function(){

   var selectAgente=$('#personaTipoAgente').val();
   $.ajax({
    type:"POST",
    url:<?php echo('"'.base_url().'persona/obtieneTipoCanal"'); ?>,
    data:{"tipoAgente":selectAgente},
    error: function(){},
    success: function(data){

      $('#id_catalog_canales').html(`
      <option value=''>Seleccione</option>
      `+data);
    }
  });
 })

//[Dennis 2020-04-01]
function validadorArchivos(){
  var archivosObligatorios=<?php if(empty($obtenerArchivosObligatorios)){echo $obtenerArchivosObligatorios=0;}else{ echo json_encode($obtenerArchivosObligatorios);}?>;
  var tipoAgente=<?php echo json_encode($datosAgente);?>;
  var docObligatorio=<?php if(empty($docObligatorios)){$docObligatorios=0; echo $docObligatorios;}else{echo json_encode($docObligatorios);}?>;
    switch(tipoAgente.personaTipoAgente){
      case "4": if(archivosObligatorios.length>=2){document.getElementById("btnPasarAgente").disabled=false;}
                else{alert('Peticion rechazada. El usuario cuenta con '+archivosObligatorios.length+' de '+docObligatorio.length+' archivos obligatorios');
                  document.getElementById("btnPasarAgente").disabled=true;}
          break;
      case "3": //Misma condición de case:2 minimo un archivo obligatorio.
      case "2": if(archivosObligatorios.length>0){document.getElementById("btnPasarAgente").disabled=false;}
                else{alert('Peticion rechazada. El usuario no cuenta con los archivos obligatorios. Se requiere minimo 1 archivo');
                  document.getElementById("btnPasarAgente").disabled=true;}
          break;
          }
}
//-------------------------------------------------------------------------------------
//[Dennis 2020-04-20]
//Opcion de cambio de opciones en modal
var selectCarga=document.getElementById("opcionesCarga");
selectCarga.addEventListener("change", function(){
  var opcionSeleccionada=selectCarga.selectedIndex;
  var divHrs=document.getElementById("cargaHrs");
  var divImg=document.getElementById("cargaImg");
  var divPadre=document.getElementsByClassName("modal-body")[0];
  var botonImg=document.getElementById("insertaImg");
  var botonCapa=document.getElementById("actualizarCapa");
  if(opcionSeleccionada==1) {
    divHrs.style.display="block";
    divImg.style.display="none";
    botonImg.style.display="none";
    botonCapa.style.display="block";
  }
  else if(opcionSeleccionada==2){
    divImg.style.display="block";
    divHrs.style.display="none";
    botonImg.style.display="block";
    botonCapa.style.display="none";
    
  }
});
//-------------------------------------------------------------------------------------
//[Dennis 2020-04-21]
//Opcion de seleccionar todos.
var checkBoxP=document.getElementById('opcionTotal');
checkBoxP.addEventListener("click", function(){
  var seleccionado=checkBoxP.checked;
  var formElementos=document.getElementById("capaForm");
  if(seleccionado){
    for(i=0;i<formElementos.length;i++){
      if(formElementos.elements[i].type=="checkbox"){
        formElementos.elements[i].checked=true;}
    }
  }
  else{
    for(i=0;i<formElementos.length;i++){
      if(formElementos.elements[i].type=="checkbox"){
        formElementos.elements[i].checked=false;}
    }
  }
});
//---------------------------------------------------------------------------------------
//[Dennis aquiSe]

//carga de horas de capacitación.
var botonCapa=document.getElementById("actualizarCapa");
var formu=document.getElementById("capaForm");
var opcionCapa=document.getElementById("opcionesCarga");

function enviaCapa(e){
  var contador=0;
  var inputText=0;
  e.preventDefault();
  $("input[type=checkbox]").each(function(){
    if($(this).is(":checked")){
      contador++;}
  });


  $("input[type=number]").each(function(){
    if($(this).val().length!=0){
      inputText++;}
  });


  if(contador>0){
    if(inputText>0){
  $.ajax({
    type:"POST",
    url:"<?php echo base_url()."capacita/ingresaCapacitacion";?>",
    data: $("#capaForm").serialize(),
    error: function(){
      alert("No se envio");
    },
    success: function(data){
      
      alert("Datos enviados");
      $('.capacitacion').modal('hide');
      $('#capaForm')[0].reset();
    }
  });}else{
    alert("Debes llenar mínimo a un campo de horas.");
  }} else{
    alert("Debes seleccionar mínimo a un agente");
  }
}
//-------------------------------------------------------------------------------------------
var submitImg=document.getElementById("insertaImg");
var cargaImg=document.getElementById("cargaImagen");
//var agentesSelect=document.getElementByName("idPersona[]");
var formCont=new FormData();
//var formCont={};
var cont_img=[];
//jugar con imagenes.
cargaImg.addEventListener("change", function(){
  var infoFile = cargaImg.files;
  if(infoFile.length!=0){
    //console.log(cargaImg.files);
    for(var i=0; i<infoFile.length; i++){

      var nombreArchivo=infoFile[i].name;
      var extension=nombreArchivo.split(".").pop().toLowerCase();
      var extValidas=["jpg","png","gif","jpeg"];
      if(extValidas.includes(extension)){

        formCont.append("archivo[]",infoFile[i]);
        //cont_img.push(infoFile[i]);

      }
      else{
        alert("Archivo con extensión no valida: "+nombreArchivo);
      }
    }
  }
});

var cuantosCheck=0;
//carga de imagenes de curso: 1-M,1-1,M-1,M-M
function enviaImg(e){
  e.preventDefault();

  //console.log(cont_img);
  var formRef=document.getElementById("capaForm");
  var contfiles=0;
  var contadorCheck=0;

  for(var j=0;j<formRef.elements.length;j++){
    if(formRef.elements[j].type=="checkbox"){
     
      if(formRef.elements[j].checked){
      
        formCont.append("agente[]",formRef.elements[j].value);
      }
    }
  }
//console.log(formCont);
  $("input[type=checkbox]").each(function(){
    if($(this).is(":checked")){
      contadorCheck++;}
  });

  $("input[type=file]").each(function(){
    if($(this).val().length!=0){
      contfiles++;}
  });
  if(contfiles>0){
    if(contadorCheck>0){
      $.ajax({
        type:"POST",
        url:"<?php echo base_url()."capacita/asignaImgCurso";?>",
        data: formCont,
        processData: false,
        contentType: false,
        cache:false,
        error: function(){
          alert("Hubo un detalle");
        },
        success: function(data){
          alert("Imagenes enviadas");
          $('.capacitacion').modal('hide');
          $('#capaForm')[0].reset();
          window.location.reload();
        }
      });
    } 
      else{
        alert("Debes seleccionar mínimo a un agente");
      }
      } else{
        alert("Seleccione mínimo una imágen");
      }
}


botonCapa.addEventListener("click", enviaCapa);
submitImg.addEventListener("click", enviaImg);
//[Dennis 2020-04-27]
//buscador de vendedores con JQuery.
/*$("#buscaVendedor").html("");
var filas=document.getElementById("contenidoTabla");
$("#buscaVendedor").on("keyup", function(){
  var datoABuscar= $(this).val();
    $.ajax({
      type:"POST",
      url:"<?=base_url()."persona/buscaVendedor"?>",
      data: {"buscaVendedor": datoABuscar},
      error: function(){
        alert('Datos erróneos');
      },
      success:function(data){
        $("#cuerpoTabla").html(data); 
      }
    })
}) */
//--------------------------------------------------------------------------------------------------------------
//[Dennis 2020-04-29]
function enviaUsuario(){
  var usuarioCreado = document.getElementById("cuentasACargo").value;
  var row="";
  $.ajax({
    type:"POST",
    url:"<?php echo base_url()."persona/prueba"?>",
    dataType:"json",
    data: {"usuarioACargo": usuarioCreado},
    error: function(){
      alert('Datos no enviados');
    },
    success: function(data){
      //$("#cuerpoTabla").html(data);
      //console.log(data);
      for(var indice in data){
        row+="<tr style='border-bottom-color:#D5D8DC; border-bottom-style: solid; border-bottom-width:1px'><td><input type='checkbox' class='opcionSelect' name='idPersona[]' value='"+data[indice].idPersona+"'></td><td style='text-align: left'>"+data[indice].nombres+" "+data[indice].apellidoPaterno+" "+data[indice].apellidoMaterno+"</td><td>"+data[indice].personaTipoAgente+"</td><td>"+data[indice].nombreTitulo+"</td><td>"+data[indice].NombreSucursal+"</td></tr>";
      }
      $("#cuerpoTabla").html(row);
    }
  });
}
//prueba de ajax vanilla js generico.
var selectCapacitacion=document.getElementById("selectCapacitacion");

function ajaxVanillaJS(){

  var xmltHttp= new XMLHttpRequest();

  var direccion="<?=base_url()."persona/devuelveCerti"?>";
  var selectName=document.createAttribute("name");
  selectName.value="selectCapacitacionName";
  selectCapacitacion.setAttributeNode(selectName);
  var selectRepuesta=document.getElementById("selectCerti");
  var contenedorSelectRespuesta=document.getElementById("contSelectCertificacion");
  contenedorSelectRespuesta.style.display="inline-block";
  selectRepuesta.innerHTML="";

  xmltHttp.onreadystatechange=function(){
    if(this.readyState==4 && this.status==200){
      //console.log(this.responseText);
      var tipoCerti=JSON.parse(this.responseText);
      
      selectRepuesta.innerHTML+="<option value=''>Seleccione un ramo</option>";
      for(var indice in tipoCerti){
        selectRepuesta.innerHTML+="<option value="+tipoCerti[indice].id_certificado+">"+tipoCerti[indice].nombreCertificado+"</option>";
      }
    }
  }
    xmltHttp.open("GET",direccion+"?"+selectName.value+"="+selectCapacitacion.value, true);
    xmltHttp.send();
}

//aquiSe 
selectCapacitacion.addEventListener("change", ajaxVanillaJS);

//--------------------------------------------------------------------------------------------
  var selectSecundario=document.getElementById("selectCerti");
  var campoTextoCerti=document.getElementsByClassName("certiOptionOculto");
  //var contenedorCamposTexto=document.getElementById("campoTextoHrs");
  //console.log(contenedorCamposTexto.length);
  
selectSecundario.addEventListener("change", function(){
  document.getElementById("contHrsCert").style.display="inline-block";
  /*if(selectSecundario.value!=0){
    /*var contHrsCont=document.getElementById("contHrsCert");
    contHrsCont.style.display="inline-block"; 

    for(var i=0;i<campoTextoCerti.length;i++){
        //campoTextoCerti[i].classList.replace("certiOptionOculto","certiOption");
        if(campoTextoCerti[i].classList.contains("certiOptionOculto")){
          campoTextoCerti[i].classList.replace("certiOptionOculto","certiOption");
        } 
    }
  }
  /*if(selectSecundario.value!=0){
    contenedorCamposTexto.classList.replace("certiOptionOculto","certiOption"); 
  } */
  //console.log(campoTextoCerti.classList.contains("certiOptionOculto"));
});



//---------------------------------------------------------------------------------------------
$("#up_img").click(function() {$("body").append('<input type="file" name="imagen[]">');$("input[name='imagen[]']").trigger("click");});

//---------------------------------------------------------------------------------------------

</script>
