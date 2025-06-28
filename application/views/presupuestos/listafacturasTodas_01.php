<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
//$totalResultados = $Listafacturas->num_rows();
?>
<?php $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php $this->load->view('headers/menu');?>
<style type="text/css">
  body{width: 100%;overflow-x: auto}
</style>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    $( function(){$( "#1fNacimiento" ).datepicker({dateFormat: 'yy-mm-dd',});} );
</script>



<?  
    $colorRef[0] = "5";
    $colorRef[1] = "8";
    $colorRef[2] = "11";
    $colorRef[3] = "14";
    $colorRef[4] = "17";
    $colorRef[5] = "20";
    $colorRef[6] = "23";
    $colorRef[7] = "26";
    $colorRef[8] = "29";
    $colorRef[9] = "32";
    $colorRef[10] = "33"; //solo llegan a 34 los colores de la libreira
    $colorRef[11] = "34";
    $colorRef[12] = "";
    $colorRef[13] = "";
    $colorRef[14] = "";

    $graficaRef     = base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
    $graficaBarras  = base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
    $graficaPastel  = base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
    $graficaPorcen  = base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
?>

<!-- <meta name="viewport" content="width=900px"/> -->

<script>
      
  <?php //if(isset($Respuesta)){ ?>
    //alert(<?php echo('"'.$Respuesta.'"'); ?>);
  <?php //} ?>           
  const baseUrl = $("#base_url").data("base-url");

  /*function enviaArchivo(){

    $(function()
    {$("#formuploadajax").on("submit", function(e){
     e.preventDefault();
     var f = $(this);
     var formData = new FormData(document.getElementById("formuploadajax"));
     $.ajax({url:"<?php echo(base_url().'presupuestos/GuardarArchivo/')?>",
      type: "post",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false
          })
      .done(function(res){
        $("#mensaje").html("Respuesta: " + res);
       });
      });
    });
  }*/



//alert(window.location.href );

//Cambio de aspecto del bot�n "Agregar (PDF o XML)" a "Descargar"
    /*function cambiaForm(objeto){
        var formData = new FormData(objeto);
        $.ajax({
            url:`${baseUrl}presupuestos/GuardarArchivo`,
            type: "post",dataType: "html",data: formData,cache: false,
            contentType: false,processData: false,
            success : function(datat) {
                console.log(datat);
                var j=JSON.parse(datat);   
                if(j.status==0){             
                    var cadena='<select><option value="'+j.ruta+'"">';
                    cadena=cadena+'Descargar</option><option value="'+j.archivo+'"">';
                    cadena=cadena+'Eliminar</option></select><button onclick="opcionesArchivo(this)">OK</button>';  
                    objeto.parentNode.innerHTML=cadena;
                }
                else {
                    alert(j.mensaje);        
                    for(var i=0; i<objeto.childNodes.length;i++){
                        if(objeto.childNodes[i].nodeName=="INPUT"){
                            if(objeto.childNodes[i].type=="file"){
                                objeto.childNodes[i].value="";
                            }
                        }
                    }
                }
            }
        })
    }*/

//Selecci�n para descargar o eliminar PDF o XML cuando se elimina el archivo
    function opcionesArchivo(objeto){ //Modificado [2024-10-17]
      var obj=objeto.parentNode;
      for (i = 0; i < obj.childNodes.length; i++) {
        if( obj.childNodes[i].nodeName=="SELECT") {
          var sel=obj.childNodes[i].selectedIndex;
          if(obj.childNodes[i].options[sel].text=="Descargar") {
              //document.location=obj.childNodes[i].value;
              window.open(obj.childNodes[i].value, '_blank');
          }
          else {
            let parametros = {
                "id" : $(objeto).data("id"),
                "file" :obj.childNodes[i].value
            };
            var direccion = "<?php echo(base_url().'presupuestos/modificaArchivo/')?>";
            swal({
                title: "¿Desea eliminarlo?",
                text: "El documento se borrará definitivamente.",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                $.ajax({
                    method: "POST",
                    data: parametros,
                    url : direccion,
                    dataType: "html",
                    success : function(datat){
                      var j = JSON.parse(datat);
                      //console.log(j);
                      if (j.status) {
                        swal("¡Eliminado!", "El documento se borró correctamente.", "success");
                        const format = j.tipo.toUpperCase();
                        var label = (j.tipo == "pdf") ? '<label class="subir-pdf" for="file">Agregar PDF</label>' : '<label class="subir-xml" for="file">Agregar XML</label>';
                        var cadena = `<div class="container-spinner" id="Spinner${format}${j.id}"></div>
                          <div class="divContenedor">
                            <form action="<?=base_url()?>presupuestos/GuardarArchivo" id="GuardarArchivo${j.id}" enctype="multipart/form-data" method="post">
                              <input type="hidden" value="${j.id}"name="id">
                              <input type="hidden" value="${j.tipo}"name="tipo">
                              <input type="hidden" value="listafacturasTodas" name="vistaProcedente">
                              <input type="file" name="Archivo" class="Archivo1" onchange="if(!this.value.length)return false; uploadFile(${j.id},'${format}');">${label}
                            </form>
                          </div>
                        `;
                        $('#file'+format+j.id).html(cadena);
                      }
                      else {
                        swal("¡Vaya!", "El documento no pudo ser eliminado. Favor de intentarlo nuevamente.", "error");
                      }
                    },
                    error: function(datat) { 
                      swal("¡No eliminado!", "Ocurrió un error al borrar el documento.", "error");
                    }
                });
              }
            });
          }
        }
      }
    }
</script>
<section class="container-fluid breadcrumb-formularios" style="padding-bottom: 15px;">
  <div class="row">
    <div class="col-md-6 col-sm-5 col-xs-5">
      <h3 class="titulo-secciones">Facturas</h3>
    </div>
    <div class="col-md-6 col-sm-7 col-xs-7">
      <a class="nav-link" style="color:#fff; font-size:15px; padding-left:10px; padding-right:10px;">
        <i class="fa fa-external-link" id="icon-poliza" aria-hidden="true"></i>
      </a>
    </div>
  </div>
  <hr/>
  <div class="col-md-12 segment-aplicar-pago">
    <div class="col-md-12" style="display: flex;padding: 10px;">
      <div class="col-md-4" style="padding: 0px; border-right: 1px solid darkgray;">
        <!-- <form method="post" id="VerFacturasTodas" action="<?=base_url().'presupuestos/VerFacturas'?>"> -->
          <div class="col-md-12 content-header-column-one">
            <div class="col-md-4">
              <label class="title-input">Fecha Inicial:</label>
              <input type="date" class="form-control input-sm" name="textFecInicial" id="textFecInicial">
            </div>
            <div class="col-md-4">
              <label class="title-input" style="width:75px;">Fecha Final:</label>
              <input type="date" class="form-control input-sm" name="textFecFinal" id="textFecFinal">
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" onclick="CargarFacturas()">
                <i class="fa fa-search" style="margin-right: 5px;"></i>
                Consultar
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6 content-header-column-one" style="padding-left: 15px;">
        <div class="col-md-7">
          <label class="title-input">Filtrar Tabla Facturas:</label>
          <select type="text" id="filtrarUsuario" onchange="filterUser()" class="form-control input-sm">
            <option value="0">Sin Usuarios para filtrar</option>
          </select>
          <!-- onkeyup="myFunction()" -->
        </div>
        <div class="col-md-5">
          <? if($this->tank_auth->get_usermail()=='CONTABILIDAD@AGENTECAPITAL.COM'){?>
            <div class="col-sm-3 col-md-3">
              <button class="btn btn-danger btn-facturas" onclick="eliminarFactura('')">
                <i class="fa fa-trash" style="margin-right: 5px;"></i>
                ELIMINAR FACTURA
              </button>
            </div>
          <?  } ?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-striped" id="TablaFacturas">
          <thead style="position: sticky;top: 0px;">
            <tr style="background: #2c608f">
              <th>Editar</th>
              <th>Id</th>
              <th>Fecha Factura</th>
              <th>Fecha Captura</th>
              <th>Folio</th>                                        
              <th>Concepto</th>                                     
              <th>Subtotal</th> 
              <th>Total a pagar</th>
              <th>Autorizado</th>
              <th>Pagado</th>
              <th>FechaPago</th>
              <th>Proveedor</th>
              <th>Agregar PDF</th>
              <th>Agregar XML</th>
              <th>Tipo Compra</th>
              <th>Usuario</th>
            </tr>
          </thead>
          <tbody class="list-table-facturas-body" id="TableBodyFacturas">
            <tr>
              <h5 id="Instruccion">Realice una consulta para ver las facturas.</h5>
            </tr>
          </tbody>
          <tfoot class="result-table-facturas-foot"></tfoot>
        </table>
      </div>
      <div class="col-md-12" style="padding: 15px;">
        <small>
          <i style="font-size: 14px;">Total de resultados: <b id="totalResultadosB">0</b></i>
        </small>
      </div>
    </div>
  </div>
</section>

<style type="text/css">
  button:active, button:focus {outline: 0!important;}
  #TablaFacturas {height: 100%; margin: 0px;}
  .Archivo1{
    opacity: 0;
    width: 150px;
    top: 28px;
    position: relative;
  }
  .divContenedor{width: 150px}
  .ocultarObjeto{display: none}
  .rowSeleccionado,
  #TablaFacturas > tbody > tr.rowSeleccionado:nth-of-type(odd) {background-color: #edf1b8}
  .result-table-facturas-foot {position: sticky;bottom: 0px; background-color: #73403E;color: white;}
  .segment-aplicar-pago {
    background: white;
    padding: 10px;
    font-size: 14px;
    box-shadow: 0px 7px 10px 1px #6a6a6a;
  }
  .content-header-column-one {
    width: auto;
    display: flex;
    align-items: flex-end;
    justify-content: center; 
    padding: 0px;
  }
  .container-downloadFile {
    padding-left: 0px;
    padding-right: 0px;
    display: flex;
    align-items: center;
    position: static;
  }
  .dropdownFile {
    font-size: 13px;
    width: 105px;
    margin-right: 6px;
    margin-top: 25px;
  }
  .container-segment {
    width: auto;
    height: 50px;
    display: flex;
    align-items: center;
  }
  .items-align-center {
    width: auto;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .items-align-left {
    width: auto;
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }
  .table-responsive {
    overflow: auto;
    height: 560px;
    /*background: #f7f7f7;*/
  }
  .title-input {
    font-size: 13px;
    margin-bottom: 0px; 
  }
  .btn-facturas {
    color: white;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 7px;
    padding-right: 7px;
    border-radius: 5px;
  }
  .btn-table-pago {
    color: white;
    padding-top: 3px;
    padding-bottom: 3px;
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 5px;
  }
  .btn-Editar {
    border-radius: 5px;
    font-size: 13px;
  }
  .subir-pdf {
    color: white;
    background-color: #d9534f;
    width: 100%;
    border: 2px solid #d9534f;
    border-radius: 5px;
    height: 30px;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .subir-xml {
    color: white;
    background-color: #2da34c;
    width: 100%;
    border: 2px solid #2da34c;
    border-radius: 5px;
    height: 30px;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .btn-OK {
    border: 2px solid #545454;
    border-radius: 5px;
    background: white;
    color: #545454;
    padding-top: 3px;
    margin-top: 25px;
  }
  .btn-OK:hover {
    background-color: #545454;
    color: white;
  }
  .swal-modal {
    width: 28%;
  }
  .swal-button--confirm{
      background-color:#337ab7!important;
  }
  .swal-text{
      /*color:#472380 !important;*/
      font-size: 17px;
      text-align: center;
  }
  .container-spinner {width: -webkit-fill-available;height: -webkit-fill-available;position: absolute;z-index: 1;}
  .container-spinner-table-facturas {
      text-align: center;
      /* margin: 10px; */
      color: #266093;
      width: 100%;
      height: 100%;
      align-items: center;
      display: flex;
      justify-content: center;
      flex-direction: column;
      left: 0px;
      position: sticky;
  }
  .container-spinner-content-loading {
      margin: 0px;
      color: #266093;
      width: 100%;
      height: 100%;
      align-items: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      background-color: rgb(255 255 255 / 95%);
      /*z-index: 1;*/
      transition: all 0.3s;
  }
  .text-align-right {
    text-align: right;
  }
  .filterSelect {
    background-color: #8ae18d;
  }
  .mostrar {
    display: table-row;
  }
</style>

<script type="text/javascript">
  //document.getElementById("miModal").classList.add("modalCierra");
   //document.getElementById("miModal").classList.remove("modalAbre");
     //document.getElementById("Modalcontenido").style.display="none";

/*function enviarForm(event){  
event.preventDefault()
  var formulario=document.getElementById('formreferidos');
  var tipoPago=document.getElementById('selectMetodoDePago').value;
  var bandSubmit=1;
  var folio = document.getElementById('folio').value;var fechas = document.getElementById('1fNacimiento').value;
if(tipoPago!=''){
if(tipoPago==3)
  { 
    if(folio !='' && fechas!=''){bandSubmit=1; }  
    else{alert('No capturaste FOLIO O FECHA DE FACTURA');} 
                 
  }
if(tipoPago==0){bandSubmit=1;}
if(tipoPago==1 || tipoPago==2 || tipoPago==4 || tipoPago==5 )
 { 
  if(fechas!=''){bandSubmit=1;}  
  else{alert('No capturaste Fecha de Factura o Documento');} 
 }
}
var id="";
if(bandSubmit){
  elementosFormulario=formulario.elements;
  total=elementosFormulario.length
  for(var i=0;i<total;i++){
    if(elementosFormulario[i].hasAttribute('required')){
      if(elementosFormulario[i].value==""){id=i;i=total+1;}}
   }
 }
 if(id!=""){
    elementosFormulario[id].focus();                         
 }
 else{formulario.submit();}
}*/


</script>
<!-- <?php
function imprimirCuentasPorDepartamentos($informacion){
  $select='<select name="filtrarUsuario" class="form-control input-sm" required>';
  foreach ($informacion as $key => $value) {
    $select.='<optgroup label="'.$key.'">';
    foreach ($informacion[$key] as  $valueDepartamento) {
      $select.='<option value="'.$valueDepartamento->idCuentaContable.'">'.$valueDepartamento->cuentaContable.'</option>';
    }
    $select.='</optgroup>';
  }
  $select.='</select>';
  return $select;
  

}
?> -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script type="text/javascript">
  $(function () {
    $(".fecha").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
    });
  });
</script>
<script type="text/javascript">
  let fechaInicial="<?echo($fechaInicial)?>";
  let fechaFinal="<?echo($fechaFinal)?>";
  let fecIni=fechaInicial.split('-');
  
  document.getElementById('textFecInicial').value="<?echo($fechaInicial)?>";
  document.getElementById('textFecFinal').value="<?echo($fechaFinal)?>";

  // Array.prototype.unique=function(a){return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0});
  //function filtrarTabla(permiso)
  //{   let option="";
  //if(permiso){
/*   <?
   
$cad='';
   foreach($usuariosQueFacturan as $value) 
   {
    if($value->Usuario!='')
    {
     if ($value === end($usuariosQueFacturan)) {$cad.='"'.$value->Usuario.'"';}
     else{$cad.='"'.$value->Usuario.'",';}
    }
   }
   echo 'let usuariosQueFacturan=['.$cad.'];';
?>
  
  let usuario=document.getElementsByName('usuarioTD');
  let cant=usuario.length;
  let array=[];
   for(let i=0;i<cant;i++){array.push(usuario[i].innerHTML.trim());}
   a=array.unique();
  let cantArray=a.length;
  option='<option></option>';
  for(let i=0;i<cantArray;i++){option=option+'<option style="background-color:#6ac16d">'+a[i]+'</option>';}
  usuariosQueFacturan.forEach(t=>{
    let band=false;
    array.forEach(a=>{if(a==t){band=true}})
    if(!band){option+=`<option>${t}</option>`}
  })
   }
   else{option='<option><?=$usuario?></option>';}
  filtrarUsuario.innerHTML=option;
 }
 
 filtrarTabla(<?=$permisoFiltroFacturas;?>);*/
/*function escogerFiltro(value)
{
   let usuario=document.getElementsByName('usuarioTD');
  let cant=usuario.length;
  let sumTotalFactura=0;
  let sumTotalFacturaConIVA=0;
  let total=0;
  for(let i=0;i<cant;i++)
  {
    usuario[i].parentNode.classList.remove('ocultarObjeto');
    sumTotalFactura=parseFloat(sumTotalFactura)+parseFloat(usuario[i].parentNode.dataset.totalfactura);
    sumTotalFacturaConIVA=parseFloat(sumTotalFacturaConIVA)+parseFloat(usuario[i].parentNode.dataset.totalfacturaconiva)
    total++;
  }  
  if(value!='')
  {
    sumTotalFactura=0;
    sumTotalFacturaConIVA=0;
    total=0;
    for(let i=0;i<cant;i++)
      {
        if(usuario[i].innerHTML.trim()!=value){usuario[i].parentNode.classList.add('ocultarObjeto')}  
        else{
              sumTotalFactura=parseFloat(sumTotalFactura)+parseFloat(usuario[i].parentNode.dataset.totalfactura);total++;
              sumTotalFacturaConIVA=parseFloat(sumTotalFacturaConIVA)+parseFloat(usuario[i].parentNode.dataset.totalfacturaconiva);
             }
      }
    
    } 
  document.getElementById('totalFacturaH4').innerHTML='$'+sumTotalFactura.toFixed(2) ;
  document.getElementById('totalFacturaConIVAH1').innerHTML='$'+sumTotalFacturaConIVA.toFixed(2) ;
  document.getElementById('totalResultadosB').innerHTML=total;
}*/


  $(document).ready(function() {
    CargarFacturas();
  })

  //Selecci�n de una fila de la Tabla
  function escogerRow(objeto) {
    if(document.getElementsByClassName('rowSeleccionado')[0]){
      document.getElementsByClassName('rowSeleccionado')[0].classList.remove('rowSeleccionado');
    }
    objeto.classList.add('rowSeleccionado');
  }

  //Eliminar Factura de la Tabla
  function eliminarFactura(datos='') {
    if(datos=='') {
      if(document.getElementsByClassName('rowSeleccionado')[0]) {
        var fila = document.getElementsByClassName('rowSeleccionado')[0].dataset.idfactura;
        swal({
            title: "¿Desea borrarlo?",
            text: "Los datos de "+fila+" se eliminarán.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
          if (value) {    
            params="id="+fila;        
            controlador="presupuestos/eliminarFactura/?";     
            peticionAJAX(controlador,params,'eliminarFactura');
          }
        });
      }
      else{
        swal({
          title: "¡Por favor!",
          text: "Seleccione factura para eliminar.",
          icon: "warning",
          button: "OK",
        });
        //alert('SELECCIONE UNA FACTURA PARA ELIMINAR')
      }
    }
    else {
      if(!datos.status){
        alert(datos.mensaje)
      }
      else {
        //let direccion='<?=base_url()?>presupuestos/VistafacturasTodas';
        //window.location.replace(direccion);
        swal("�Eliminado!", "La fila se borr� correctamente. La p�gina se recargar� en breve.", "success");
        window.location.reload();
      }
    }
  }

  function peticionAJAX(controlador,parametros,funcion){
    var req = new XMLHttpRequest();
    var direccionAJAX="<?= base_url();?>";
    var url=direccionAJAX+controlador;
    req.open('POST', url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function (aEvt) {
        if (req.readyState == 4) {
            if(req.status == 200) {           
              var respuesta=JSON.parse(this.responseText); 
              window[funcion](respuesta);                                                          
            }     
        }
    };
    req.send(parametros);
  }


  // $(document).ready(function() {
  //   $('#GuardarPDF').validate({
  //     submitHandler: function(form) {
  //       console.log(form);
  //       $.ajax({
  //         url: form.action,
  //         type: form.method,
  //         data: $(form).serialize(),
  //         success: function(response) {
  //           console.log("Documento subido"+response);
  //           //window.location.reload();
  //         }
  //       })
  //     }
  //   })
  // })

  //Global
  const money = { style: 'currency', currency: 'MXN' };
  const numberFormat = new Intl.NumberFormat('es-MX', money);

  function CargarFacturas() { //Modificado [Suemy][2024-10-17]
    const fecha_i = document.getElementById('textFecInicial').value;
    const fecha_f = document.getElementById('textFecFinal').value;

    $.ajax({
      type: "POST",
      url: `<?=base_url()?>presupuestos/VerFacturas`,
      data: {
          textFecInicial: fecha_i,
          textFecFinal: fecha_f
      },
      beforeSend: (load) => {
          $('.list-table-facturas-body').html(`
            <tr>
              <td colspan="16">
              <div class="container-spinner-table-facturas">
                  <div class="bd-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
              </div>
              </td>
            </tr>
          `);
          $('#filtrarUsuario').html(`<option value="0">Sin Usuarios para filtrar</option>`);
          $('#Instruccion').addClass('hidden');
          $('.result-table-facturas-foot').html("");
      },
      success: (data) => {
        //console.log(data);
        const InfoFacturas = JSON.parse(data);
    

        const fltr = InfoFacturas['user'];
        const fact = InfoFacturas['fact'];
        var trtd = ``;
        var tfoot = ``;
        var filePDF = ``;
        var fileXML = ``;
        var user = `<option value="0">TODOS</option>`;
        var filtrarUs = "";

        for (var u in fltr) {
          const usuario = valueNull(fltr[u].Usuario);
          if (usuario != 0) {
            user += `<option name="FilterUser" data-user="${usuario}">${usuario}</option>`;
          }
        }
        $('#filtrarUsuario').html(user);

        if (fact != 0) {
          for (var f in fact) {
            const id_fact = fact[f].id;
            const fecha_factura = valueNull(fact[f].fecFactura);
            const fecha_captura = valueDate(fact[f].fecha_captura);
            const folio_factura = valueNull(fact[f].folio_factura);
            const concepto = valueNull(fact[f].concepto);
            const subtotal = valueNumber(fact[f].totalfactura);
            const totalpagar = valueNumber(fact[f].totalconiva);
            const fecha_pago = valueNull(fact[f].fecha_pago);
            const idProveedor = valueNull(fact[f].idProveedor);
            const archivoNombrePDF = valueNull(fact[f].archivoNombrePDF);
            const archivoNombreXML = valueNull(fact[f].archivoNombreXML);
            const proveedor = GetProveedor(fact[f].idProveedor);
            var autorizado = fact[f].autorizadireccion != 0 ? "AUTORIZADO" : "PENDIENTE";
            var pagado = fact[f].pagado != 0 ? "PAGADO" : "PENDIENTE";
            var tipoCompra = "Factura Pospuesta";

            //Tipo de Compra
            switch(fact[f].posteriorapago) {
              case '1': tipoCompra = "Factura Normal"; break;
              case '2': tipoCompra = "Caja Chica"; break;
              case '3': tipoCompra = "Toka"; break;
              case '4': tipoCompra = "Amex"; break;
              case '5': tipoCompra = "Nomina y Otros"; break;
              case '6': tipoCompra = "Suma Caja Chica"; break;
              case '9': tipoCompra = "DINNERCAP"; break;
            }

            trtd += `
              <tr data-totalfactura="${fact[f].totalfactura}" data-totalfacturaconiva="${fact[f].totalconiva}" data-idfactura="${fact[f].id}" onclick="escogerRow(this)" class="mostrar">
                <td>`;

            if (fact[f].validada == "0") {                
              trtd+=`      <button class="btn btn-primary" onclick="datosDeFacturaEFG('',${fact[f].id});abrirCerrarEditarFactura(true)">Editar</button>`;
              }
              else {
                trtd += ``;
              if(InfoFacturas.userEmail=='SISTEMAS@ASESORESCAPITAL.COM' || InfoFacturas.userEmail=='CONTABILIDAD@AGENTECAPITAL.COM' || InfoFacturas.userEmail=="GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX"){
                trtd+=`<button class="btn btn-primary" onclick="datosDeFacturaEFG('',${fact[f].id});abrirCerrarEditarFactura(true)">Editar</button>`;
                }
              }

                trtd += `
                </td>
                <td>${fact[f].id}</td>
                <td id="rowFechaFactura${fact[f].id}">${fecha_factura}</td>
                <td>${fecha_captura}</td>
                <td id="rowFolioFactura${fact[f].id}">${folio_factura}</td>
                <td id="rowConcepto${fact[f].id}">${concepto}</td>
                <td id="rowTotalFactura${fact[f].id}"  class="text-align-right" name="SubTotal" data-sub="${subtotal}">${numberFormat.format(subtotal)}</td>
                <td id="rowTotalConIva${fact[f].id}"  class="text-align-right" name="TotalPagar" data-total="${totalpagar}">${numberFormat.format(totalpagar)}</td>
                <td>${autorizado}</td>
                <td>${pagado}</td>
                <td>${fecha_pago}</td>
                <td id="rowNombreProveedor${fact[f].id}" name="NombreProveedor" data-idProv="${idProveedor}"></td>
                <td id="filePDF${fact[f].id}">`;

              if (archivoNombrePDF != 0) {
                trtd += `
                  <div class="col-md-12 container-downloadFile">
                    <select class="form-control input-sm dropdownFile">
                      <option value=<?php echo('"'.base_url().'ArchivosPresupuesto/${id_fact}/${archivoNombrePDF}"')?>>Descargar</option>                                             
                      <option value="${archivoNombrePDF}">Eliminar</option>
                    </select>
                    <button type="button" class="btn-OK" data-id="${fact[f].id}" onclick="opcionesArchivo(this)">OK</button>
                  </div>`;
              }
              else {
                trtd +=  `
                  <div class="container-spinner" id="SpinnerPDF${id_fact}"></div>
                  <div class="divContenedor">
                    <form action="<?=base_url()?>presupuestos/GuardarArchivo" id="GuardarArchivo${fact[f].id}" enctype="multipart/form-data" method="post">
                      <input type="hidden" value="${id_fact}" name="id">
                      <input type="hidden" value="pdf" name="tipo">
                      <input type="hidden" value="listafacturasTodas" name="vistaProcedente">
                      <input type="file" name="Archivo" class="Archivo1" onchange="if(!this.value.length)return false; uploadFile(${id_fact},'PDF');">
                      <label class="subir-pdf" for="file">Agregar PDF</label>
                    </form>
                  </div>`;
              }

            trtd +=`</td><td id="fileXML${fact[f].id}">`;

              if (archivoNombreXML != 0) {
                trtd += `
                  <div class="col-md-12 container-downloadFile">
                    <select class="form-control input-sm dropdownFile">
                      <option value=<?php echo('"'.base_url().'ArchivosPresupuesto/${id_fact}/${archivoNombreXML}"')?>>Descargar</option>                                             
                      <option value="${archivoNombreXML}">Eliminar</option>
                    </select>
                    <button type="button" class="btn-OK" data-id="${fact[f].id}" onclick="opcionesArchivo(this)">OK</button>
                  </div>`;
              }
              else {
                trtd +=  `
                  <div class="container-spinner" id="SpinnerXML${id_fact}"></div>
                  <div class="divContenedor">
                    <form action="<?=base_url()?>presupuestos/GuardarArchivo" id="GuardarArchivo${fact[f].id}" enctype="multipart/form-data" method="post">
                      <input type="hidden" value="${id_fact}" name="id">
                      <input type="hidden" value="xml" name="tipo">
                      <input type="hidden" value="listafacturasTodas" name="vistaProcedente">
                      <input type="file" name="Archivo" class="Archivo1" onchange="if(!this.value.length)return false; uploadFile(${id_fact},'XML');">
                      <label class="subir-xml" for="file">Agregar XML</label>
                    </form>
                  </div>`;
              }

              trtd +=`
                </td>
                <td id="rowFormaPago${fact[f].id}">${tipoCompra}</td>
                <td name="CorreoUsuario" data-name="${fact[f].Usuario}">${fact[f].Usuario}</td>
              </tr>`;

              //user += `<option>${fact[f].Usuario}</option>`;
              $('option[name="FilterUser"][data-user="'+fact[f].Usuario+'"]').addClass('filterSelect');
          }
          tfoot += `
            <tr>
              <td colspan="7"><h4 id="totalFacturaH4" class="text-align-right"></h4></td>
              <td colspan="9"><h4 id="totalFacturaConIVAH1"></h4></td>
            </tr>`;
        }
        else {
          trtd += `<tr><td colspan="16"><center><b>No se encontraron registros.</b></center></td></tr>`;
        }
        $(".list-table-facturas-body").html(trtd);
        $('.result-table-facturas-foot').html(tfoot);
        //sumasTotales();
        filterUser();
      }
    })
  }

  function uploadFile(id,type_f) { //Creado [Suemy][2024-10-17]
    var formData = new FormData(document.getElementById("GuardarArchivo"+id));
    $.ajax({
        url: `<?=base_url()?>presupuestos/GuardarArchivo`,
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: (load) => {
            /*$('#Spinner'+type_f+id).html(`
                <div class="container-spinner-content-loading">
                    <div class="cr-spinner spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    <p class="cr-cargando" style="font-size:18px;">Enviando...</p>
                </div>
            `);*/
        },
        success: (data) => {
            const r = JSON.parse(data);
            //console.log(r);
            let fl = r['file'];
            let type = r['status_type'];
            const format = r['format'];
            var title = "";
            var message = "";
            var status = "";
            switch(type) {
              case 1:
                title = "¡Guardado!";
                message = "Documento guardado correctamente.";
                status = "success";
                $('#file'+format+id).html(`
                  <div class="col-md-12 container-downloadFile">
                    <select class="form-control input-sm dropdownFile">
                      <option value="${fl.ruta}">Descargar</option>                                             
                      <option value="${fl.archivo}">Eliminar</option>
                    </select>
                    <button type="button" class="btn-OK" data-id="${id}" style="padding-top: 3px;margin-top: 25px;" onclick="opcionesArchivo(this)">OK</button>
                  </div>
                `);
                break;
              case 2:
                title = "¡Espera!";
                message = "El formato del documento no es válido. Favor de subir el archivo con formato PDF o XML.";
                status = "warning";
                break;
              case 3:
                title = "¡Error!";
                message = "Hay conflicto al intentar subir el documento.";
                status = "error";
                break;
            }
            swal(title,message,status);
        },
        error: (error) => {
            console.log(error);
            $('#Spinner'+format+id).html("");
            swal("¡Uups!", "Hay problemas al intentar guardar.", "error");
        }            
    })
  }

  function GetProveedor(idProveedor) {
    const id = idProveedor;

    $.ajax({
      type: "GET",
      url: `<?=base_url()?>presupuestos/GetProveedor`,
      data: {
          id: id
      },
      success: (data) => {
        const proveedor = JSON.parse(data);
        prvdr = proveedor;
        $('td[name="NombreProveedor"][data-idProv="'+id+'"]').text(proveedor);
      }
    })
  }

  /*function sumasTotales() {
    var SumaSubTotal = 0;
    var SumaTotalPagar = 0;
    let SubTotal = document.getElementsByName('SubTotal');
    let TotalPagar = document.getElementsByName('TotalPagar');

    for (let i=0; i<SubTotal.length; i++){
      var sub = $(SubTotal[i]).data('sub');
      SumaSubTotal += parseFloat(sub);
    }

    for (let i=0; i<TotalPagar.length; i++){
      var total = $(TotalPagar[i]).data('total');
      SumaTotalPagar += parseFloat(total);
    }

    $('#totalFacturaH4').text(numberFormat.format(SumaSubTotal));
    $('#totalFacturaConIVAH1').text(numberFormat.format(SumaTotalPagar));
    console.log("SubTotal: " + SumaSubTotal + ", TotalPagar: " + SumaTotalPagar);
    //SubTotal: $216319.4, TotalPagar: $229482.69 || 216319.39999999997
  }*/

  function filterUser() {
    var input, filter, table, tr, td, i, j, visible;
    input = document.getElementById("filtrarUsuario");
    filter = input.value.toUpperCase();
    table = document.getElementById("TableBodyFacturas");
    tr = table.getElementsByTagName("tr");
    //tr = $('#TablaFacturas').find('tbody tr');
    //td = $('#TablaFacturas').find('tbody tr td:nth-child(16)');
    var result = 0;
    var SumaSubTotal = 0;
    var SumaTotalPagar = 0;
    var sub = "";
    var total = "";
    let SubTotal = document.getElementsByName('SubTotal');
    let TotalPagar = document.getElementsByName('TotalPagar');
    let Fila = document.getElementsByClassName('mostrar');

    for (i = 0; i < tr.length; i++) {
      visible = false;
      td = tr[i].getElementsByTagName("td");
      for (j = 0; j < td.length; j++) {
        if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
          visible = true;
        }
      }
      if (visible === true) {
        tr[i].style.display = "";
        sub = $(SubTotal[i]).data('sub');
        total = $(TotalPagar[i]).data('total');
        SumaSubTotal += parseFloat(sub);
        SumaTotalPagar += parseFloat(total);
        $(tr[i]).addClass('mostrar');
        //console.log(sub, total);
      }
      else {
        tr[i].style.display = "none";
        $(tr[i]).removeClass('mostrar');
      }
    }
    result = Fila.length;
    //console.log("El SubTotal visible es: " + SumaSubTotal + ", el TotalPagar visible es: " + SumaTotalPagar + ". Filas: "+result);
    $('#totalFacturaH4').text(numberFormat.format(SumaSubTotal));
    $('#totalFacturaConIVAH1').text(numberFormat.format(SumaTotalPagar));
    $('#totalResultadosB').text(result);
  }

  function nuevaVentana(e,objeto){
    e.preventDefault();
    window.open(objeto.getAttribute('href'));
  }

  function valueNull(data) {
    var value = data;

    if (value == null || value == undefined || value == "[object Object]" || value == 0) {
      value = "";
    }
    return value;
  }

  function valueDate(data) {
    var date = "";
    var value = data;
    var numeromeses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
    var numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

    if (value == null || value == undefined) {
      value = "";
    }
    else {
      value = new Date(data);
      date = value.getFullYear() + "-" + numeromeses[value.getMonth()] + "-" + numerodias[value.getDate()];
    }
    return date;
  }

  function valueNumber(data) {
    var number = 0;

    if (data == null || data == undefined || isNaN(data)) {
      number = 0;
    }
    else {
      number = data;
    }
    return number;
  }
</script>
<?php $this->load->view('footers/footer'); ?><div id="modalModifcaFactura" style="display: flex;flex-direction: column;" >
  <div style="background:#007bff;display: flex;margin-left: 2%;flex-direction: row-reverse;margin-right: 2%"><button onclick="abrirCerrarEditarFactura()" style="background-color: red;color: white">X</button></div>
  <div id="modalcontenidoFactura" class="modal-contenido"  style="background-color: white">
   <?php $this->load->view('presupuestos/editarFacturaGeneral');?>
  </div> 

</div>
<script type="text/javascript">
 function abrirCerrarEditarFactura(abrir=false)
 {
  if(abrir){
  document.getElementById("modalModifcaFactura").classList.remove("modalCierra");
  document.getElementById("modalModifcaFactura").classList.add("modalAbre");
   document.getElementById("modalModifcaFactura").style.display="block";
   }
   else
   {
      document.getElementById("modalModifcaFactura").classList.add("modalCierra");
   document.getElementById("modalModifcaFactura").classList.remove("modalAbre");
     document.getElementById("modalModifcaFactura").style.display="none";

   }
 }
 abrirCerrarEditarFactura();

  guardarEFG_BTN.addEventListener('click',function(){actualizarDatosFacturaEFG('actualizarTablaFactura')});

function actualizarTablaFactura(datos)
{
  
  if(datos.success==1)
  {
    alert('Actualizacion con exito de la factura');
    console.log(datos);
    document.getElementById('rowConcepto'+datos.idFactura).innerHTML=datos.factura.concepto;
    document.getElementById('rowFechaFactura'+datos.idFactura).innerHTML=datos.factura.fecha_factura;
    document.getElementById('rowFolioFactura'+datos.idFactura).innerHTML=datos.factura.folio_factura;
    document.getElementById('rowTotalFactura'+datos.idFactura).innerHTML=datos.factura.totalfactura;
    document.getElementById('rowTotalConIva'+datos.idFactura).innerHTML=datos.factura.totalconiva;
    document.getElementById('rowNombreProveedor'+datos.idFactura).innerHTML=datos.factura.NombreProveedor;
    document.getElementById('rowFormaPago'+datos.idFactura).innerHTML=datos.factura.formaPago;
  }

}

</script>
<style type="text/css">
  ..modal-contenido{background-color:white;width:95%;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000;overflow: auto; }
    .modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
  .modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
</style>