<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
?>
<?php $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php $this->load->view('headers/menu');?>



<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  
    $( function(){$( "#1fNacimiento" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );
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

<!--meta name="viewport" content="width=900px"/-->

<script language="javascript" type="text/javascript">


    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
        var DivHR = document.getElementById('DivHeaderRow');
        var DivMC = document.getElementById('DivMainContent');
        var DivFR = document.getElementById('DivFooterRow');

        //*** Set divheaderRow Properties ****
        DivHR.style.height = headerHeight + 'px';
        DivHR.style.width = (parseInt(width) - 16) + 'px';
        DivHR.style.position = 'relative';
        DivHR.style.top = '0px';
        DivHR.style.zIndex = '10';
        DivHR.style.verticalAlign = 'top';

        //*** Set divMainContent Properties ****
        DivMC.style.width = width + 'px';
        DivMC.style.height = height + 'px';
        DivMC.style.position = 'relative';
        DivMC.style.top = -headerHeight + 'px';
        DivMC.style.zIndex = '1';

        //*** Set divFooterRow Properties ****
        DivFR.style.width = (parseInt(width) - 16) + 'px';
        DivFR.style.position = 'relative';
        DivFR.style.top = -headerHeight + 'px';
        DivFR.style.verticalAlign = 'top';
        DivFR.style.paddingtop = '2px';

        if (isFooter) {
         var tblfr = tbl.cloneNode(true);
      tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
         var tblBody = document.createElement('tbody');
         tblfr.style.width = '100%';
         tblfr.cellSpacing = "0";
         //*****In the case of Footer Row *******
         tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
         tblfr.appendChild(tblBody);
         DivFR.appendChild(tblfr);
         }
        //****Copy Header in divHeaderRow****
        DivHR.appendChild(tbl.cloneNode(true));
     }
    }


    function OnScrollDiv(Scrollablediv) {
    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

    window.onload = function() {
   //MakeStaticHeader('Mitabla', 350, 1750, 40, false)
}



function Suma()
{
  var sumita;
  var CargoFianzas= document.getElementById("CargoFianzas").value 
  var CargoInst= document.getElementById("CargoInst").value 
  var CargoGes= document.getElementById("CargoGes").value 
  var Corporativos= document.getElementById("Corporativos").value
  var Asesores= document.getElementById("Asesores").value
  sumita=Number(CargoFianzas)+Number(CargoInst)+Number(Corporativos)+Number(CargoGes)+Number(Asesores);
  document.getElementById("CargoTotal").value = sumita;
  document.getElementById("CargoTotalconIVA").value = sumita;
  document.getElementById('motivoCambioPorcentajeDiv').classList.remove('verOcultar')
  }


 </script>

<script>
      
   <?php if(isset($Respuesta)){ ?>
    alert(<?php echo('"'.$Respuesta.'"'); ?>);
    <?php } ?>           

  function enviaArchivo(){

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
  }



//alert(window.location.href );

 function cambiaForm(objeto)
 {
//document.getElementById("miModal").classList.remove("modalCierra");
  //document.getElementById("miModal").classList.add("modalAbre");
   //document.getElementById("Modalcontenido").style.display="block";

   var formData = new FormData(objeto);
   $.ajax({url:"<?php echo(base_url().'presupuestos/GuardarArchivo/')?>",
     type: "post",dataType: "html",data: formData,cache: false,
     contentType: false,processData: false,
     success : function(datat)
     {
     console.log(datat);
      var j=JSON.parse(datat);   
      if(j.status==0){             
      var cadena='<select><option value="'+j.ruta+'"">';
      cadena=cadena+'Descargar</option><option value="'+j.archivo+'"">';
      cadena=cadena+'Eliminar</option></select><button onclick="opcionesArchivo(this)">OK</button>';  
      objeto.parentNode.innerHTML=cadena;
       }
       else
       {
        alert(j.mensaje);        
        for(var i=0; i<objeto.childNodes.length;i++){
          if(objeto.childNodes[i].nodeName=="INPUT"){
           if(objeto.childNodes[i].type=="file"){
            objeto.childNodes[i].value="";
           }
          }
        }
       }
         document.getElementById("miModal").classList.add("modalCierra");
   document.getElementById("miModal").classList.remove("modalAbre");
     document.getElementById("Modalcontenido").style.display="none";
     }
  })
  
    
 }

  function opcionesArchivo(objeto){ //Modificado [Suemy][2024-10-17]
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
          Swal.fire({
              title: "¿Desea eliminarlo?",
              text: "El documento se borrará definitivamente.",
              icon: "warning",
              showCancelButton:true,
              cancelButtonColor:'#d33',
              confirmButtonText:'Aceptar',
              cancelButtonText:'Cancelar'
          }).then((value) => {
            if (value.isConfirmed) {
              $.ajax({
                  method: "POST",
                  data: parametros,
                  url : direccion,
                  dataType: "html",
                  success : function(datat){
                    var j = JSON.parse(datat);
                    console.log(j);
                    if (j.status) {
                      Swal.fire("¡Eliminado!", "El documento se borró correctamente.", "success");
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
                      Swal.fire("¡Vaya!", "El documento no pudo ser eliminado. Favor de intentarlo nuevamente.", "error");
                    }
                  },
                  error: function(datat) { 
                    Swal.fire("¡No eliminado!", "Ocurrió un error al borrar el documento.", "error");
     }
    });
  }
          });
        }
      }
    }
  }
</script>
<style>
.modalProveedoor
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}
.modalGastos
{
  background-color:rgba(0,0,0,0.8);
  position:fixed;
  display:none;
  height:100vh;
  width:100vw;
  transition:all .5s;
  top:0;
  left:0;
  right:0;
  bottom:0;
  z-index:1040;
  overflow:hidden;
  outline:0;
}

.contenedor-modProve
{
    background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 700px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 0px;
    height: 800px;
}
.cabeceramodal{text-align:center;border-bottom: 1px solid #fe4918;margin-top:0px;}
.cabeceramodal h2 {padding: 1px 0;}
.contenidomodal{display:flex;justify-content:space-between;height:7rem;padding: 1rem 1rem;width :100%;align-items:center;text-align:center;}
.contenidogastos
{
  width:300px;
  margin:0 auto;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  align-items:center;
  text-align:center; 
}
.contenidogastos label{margin:20px 20px;}
.contenidogastos label:last-child{margin-right:0px;}

.cierra-modalTarea i{font-size:20px;color:red;}
.contenidomodal input{width:30rem;padding:5px 10px;margin-right:5px;}
.contenidomodal select{width:30rem;padding:5px 10px;margin-right:10px;}
.contenidomodal label{padding:5px;}
.cierra-modal{height: 20px;margin-right:36px ;}

.btncierra
{
    display: flex;
    justify-content: flex-end;   
    padding:5px;
    margin-right: 20px; 
}
.grabaFecha
{
    display: flex;
    align-items: center; 
    justify-content: flex-end;    
    height: 60px;
    width:10rem;
    margin-left:80%;
   
}
.btnGrabaproveedor{
  color:white;
   text-align:center;
   margin: 0 auto;
   align-items:center;
   background-color:#fe4918;
   padding:10px 20px;
}
.btnGrabaproveedor:hover{
cursor:pointer;
background-color:blue;
}
.agregasto{
  display:flex;
  justify-content:center;
  align-items:center;
}
.agregasto i{
 font-size:20px;
 color:red;
 padding-left:3px;
}
.agregasto i:hover{
  cursor:pointer;
  color:green;
}
.contenedor-modalGastos{
  background-color:rgb(221,241,241);
  align-items:center;
  width:700px;
  margin-left:auto;
  margin-right:auto;
  margin-top:50px;
  height:400px;
}
.lblgastos{
   display:flex;
   justify-content:space-between;   
   text-align:center;
   align-items:center;
}
.lblgastos input{  
  height:30px;
}
.grabaGastos{
  display:flex;
  justify-content:center;
  text-align:center;
   align-items:center;
   margin-top:20px;
}
.btnGrabagastos{
  padding: 10px 20px;
  background-color:green;
  color:white;
}
.btnGrabagastos:hover{
  background-color:blue;
  cursor:pointer;
  
}
.verOcultar{display: none}

/* [Suemy][2024-10-17] */
  .Archivo1{opacity: 0;width: 150px;top: 28px;position: relative;}
  .rowSeleccionado, #Mitabla > tbody > tr.rowSeleccionado:nth-of-type(odd){background-color: #edf1b8}
  .table-responsive {background: white;border: 1px solid #ddd;max-height: 500px;overflow: auto;}
  #Mitabla thead {position: sticky;top: 0;}
  .container-downloadFile {padding-left: 0px;padding-right: 0px;display: flex;align-items: center;position: static;}
  .dropdownFile {font-size: 13px;width: 105px;margin-right: 6px;margin-top: 25px;}
  .subir-pdf {color: white;background-color: #d9534f;width: 100%;border: 2px solid #d9534f;border-radius: 5px;height: 30px;font-size: 13px;display: flex;align-items: center;justify-content: center;}
  .subir-xml {color: white;background-color: #2da34c;width: 100%;border: 2px solid #2da34c;border-radius: 5px;height: 30px;font-size: 13px;display: flex;align-items: center;justify-content: center;}
  .btn-OK {border: 2px solid #545454;border-radius: 5px;background: white;color: #545454;padding-top: 3px;margin-top: 25px;}
  .btn-OK:hover {background-color: #545454;color: white;}
  .swal-modal, .swal2-modal {width: 28%; /* 68% height: 40%*/}
  .swal-button--confirm{background-color:#337ab7!important;}
  .swal-text, .swal2-html-container{/*color:#472380 !important;*/font-size: 15px;text-align: center;}
  .swal2-title {font-size: 22px;}
  .swal2-icon {font-size: 15px;}
  .swal2-styled.swal2-confirm, .swal2-styled.swal2-cancel {font-size: 13px;}
/**/
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
 <section class="container-fluid breadcrumb-formularios">
 <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">ALTA DE FACTURAS Y PAGOS CON TARJETAS</h4><button class="btn btn-primary" onclick="traerFormasPagos('')" style="display: none">Crear Notas</button><button class="btn btn-primary" onclick="buscarPersonasConNotas('')" style="display: none">Notas</button></div>
 </section>
 <hr>     
 <!--huricm 12-03-2021 Modal gastos Especiales-->
 <div class="modalGastos">
  <div class="contenedor-modalGastos">
  <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalgasto()"><i class="fas fa-times"></i></button>             
        </div>
        <div class="cabeceramodal">
          <h2>Gastos Especiales</h2>
        </div> 
        <div class="contenidogastos">
         <div class="lblgastos">
          <label for="">GASTOS CCC </label>
          <input type="text" id="gastosCcc" name = "gastosCcc" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.0">
        </div> 
        <div class="lblgastos">
          <label for="">GASTOS CCO</label>
          <input type="text" id="gastosCco" name = "gastosCco" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.0">
         </div>  
         <div class="lblgastos">
           <label for="">INVERSIONES</label>
           <input type="text" id="gastosInst" name = "gastosInst" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.0">
           </div>   
         <div class="lblgastos">
           <label for="">ESTRATEGIA</label>
           <input type="text" id="gastosEstrategia" name = "gastosEstrategia" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.0">
           </div>                       
        </div>
        <div class= "grabaGastos">
          <a  class ="btnGrabagastos btn btn-success">Guardar</a>
        </div>
     </div>
 </div>
 <!--huricm 12-03-2021 Modal actualiza Proveedor-->
  <div class="modalProveedoor" id="modProve">      
   <div class="bodymodal">   
     <div class="contenedor-modProve">   
       <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierraModalfecha()"><i class="fas fa-times"></i></button>             
        </div>
        <div class="cabeceramodal">
          <h2>Proveedor</h2>
        </div> 
        <div class="contenidomodal">
          <label for="">Proveeedor
          <input type="text" id="mproveedor" name = "mproveedor" >
          </label>
          <label for="">Contacto
          <input type="text" id="mcontacto" name = "mcontacto">
          </label>
        </div>
        <div class="contenidomodal">
          <label for="">Telefono
          <input type="text" id="mtelefono" name = "mtelefono"></label>
          <label for="">Extencion
          <input type="text" id="mextencion" name = "mextencion"></label>
        </div>
        <div class="contenidomodal">
          <label for="">Celular
          <input type="text" id="mcelular" name = "mcelular"></label>
          <label for="">Correo
          <input type="text" id="mcorreo" name = "mcorreo"></label>
        </div>
        <div class="contenidomodal">
          <label for="">Direccion
          <input type="text" id="mdireccion" name = "mdireccion"></label>
          <label for="">Banco
          <input type="text" id="mbanco" name = "mbanco"></label>
        </div>
        <div class="contenidomodal">
          <label for="">Cuenta
          <input type="text" id="mcuenta" name = "mcuenta"></label>
          <label for="">Clave
          <input type="text" id="mclave" name = "mclave"></label>
        </div>
        <div class="contenidomodal">
          <label for="">Dias de Credito
          <input type="text" id="mdias" name = "mdias"></label>
          <label for="">Giro
          <select name="mgiro" id="mgiro">
          <?foreach($catalogogiro as $row)
          {
            ?>
            <option value="<?php echo $row->giro?>"><?php echo $row->giro?></option>  
            <?
          }
          ?>
          </select></label>
        </div>
        <div class= "grabaFecha">
          <a  class ="btnGrabaproveedor">Guardar</a>
        </div>
        <input type="hidden" id="idprovee" name = "idprovee">

      </div>
   </div>
  </div>                  
 <!--Temina Modal -->
<section class="container-fluid breadcrumb-formularios">
  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>presupuestos/GuardarFactura/" > 


         <div class="row"> 
          <div class="col-sm-1 col-md-1"> 
            <label class="etiquetaSimple">Apertura</label>
             <input type="text" class="form-control"  name="AperturaConta" id="AperturaConta" placeholder="Folio de Apertura"  required=""  disabled ="disable" value ="<?= $Apertura ?>">               
            </div>

          <div class="col-sm-3 col-md-3">
            <label for="SUCUR" class="etiquetaSimple">Sucursal</label>
              <select name="SUCUR" id="IngMen" size="1" class="form-control" required="">
                  <option value="">Seleccione una opcion</option>
                  <option value="MERIDA">MERIDA</option>
                  <option value="NORTE">NORTE</option>
                  <option value="CANCUN">CANCUN</option>
                </select>
          </div> 
                           <div class="col-sm-3 col-md-3">
        <label class="etiquetaSimple">Tarjeta(escoger si es necesario)</label>
            <select class="form-control"  name="tarjetaCredito" id="selectTarjetasCredito" placeholder="Tarjeta"  >  </select>
          </div>
                     <div class="col-sm-3 col-md-3">

           <label  for="provee" class="etiquetaSimple">Proveedor</label>
           <select name="provee" id="provee" class="form-control input-sm" required="">
             <option value="">Seleccione un Proveedor</option>
            <? if(!empty($ListaProveedores))
              { foreach ($ListaProveedores->result() as $Registro) {  ?> 
                <option value="<?=$Registro->id ?>"  ><? print $Registro->NombreProveedor?> </option>
                <? }} else {?><option value="false">Vendedor No encontrado !!!</option><?}?>          
          </select>
          </br>
        </div>
    </div>
          <div class="row">
            <div class="col-sm-6 col-md-6">
            <label class="etiquetaSimple">Cuentas contables</label>
            <?php if(isset($cuentasPorDepartamento)){echo(imprimirCuentasPorDepartamentos($cuentasPorDepartamento));} ?>          
            </div>
            <div class="col-sm-5 col-md-6">
              <label class="etiquetaSimple">Forma de pago</label>
            <select id="selectMetodoDePago" name="hayfactura" class="form-control"  required="">
              <!--option></option>
              <option value="2">GASTO CAJA CHICA </option>
              <option value="3">TARJETA TOKA</option>
              <option value="4">TARJETA AMEX </option>
              <option value="5">NOMINA Y OTROS (Este no requiere autorizacion y se registra como pago REALIZADO)</option>
              <option value="1">FACTURA NORMAL</option>
              <option value="0">FACTURA POSTERIOR A PAGO</option>
              <option value="9">DINNERCAP</option-->
                <?=imprimirPermisosFormaPago($permisosFormaPago);?>
            </select>
          </div>
          </div> 
           


          <div class="row"> 
          <div class="col-sm-4 col-md-4">
            <label class="etiquetaSimple">Folio de Factura:</label>
            <input type="text" class="form-control"  name="folio" id="folio" placeholder="Folio de Factura"  >  
          </div>
          <div class="col-sm-4 col-md-4">
            <label class="etiquetaSimple">Fecha de Factura o Documento o Fecha Ingreso: </label>                
            <input type="text" class="form-control"  name="1fNacimiento" id="1fNacimiento" placeholder="Fecha de Factura"  autocomplete="off">
       </div>

       </div> 
           <div class="row">
           <div class="col-sm-8 col-md-8">          
            <label class="etiquetaSimple">Concepto:</label>
            <input type="text"  name="concepto" id="concepto" size="150" placeholder="(200 Caracteres)" required="" class="form-control" >              
          </div>
          <div class="col-sm-4 col-md-4">
             <label for="CargoFianzas" class="etiquetaSimple">Subtotal:</label>
                <input type="text" name="CargoTotal" id="CargoTotal" class="form-control input-sm" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  onchange="calculaPagoDeCanal()" value="0.00" required="">              
          </div>
           </div>
           <div class="row" id="divContieneNotasParaFacturar"></div> 
            <div class="row">
             <div class="col-sm-2 col-md-2">
             <label for="CargoFianzas" class="etiquetaSimple"><span class="badge pull-right" id="spanCargoFianzas"></span>Cargo Fianza:</label>
                <input type="text" name="CargoFianzas" id="CargoFianzas" class="form-control input-sm" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.00" onchange="Suma()">              
           </div>

            <div class="col-sm-2 col-md-2">
             <label for="CargoFianzas" class="etiquetaSimple"><span class="badge pull-right" id="spanCargoSeguros"></span>Cargo Institucional:</label>
                <input type="text" name="CargoInst" id="CargoInst" class="form-control input-sm" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.00" onchange="Suma()">              
           </div>


            <div class="col-sm-2 col-md-2">
             <label for="CargoFianzas" class="etiquetaSimple"><span class="badge pull-right" id="spanCargoCoorporativo"></span>Cargo Corporativo:</label>
                <input type="text" name="Corporativos" id="Corporativos" class="form-control input-sm" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.00" onchange="Suma()">              
           </div>
          

            <div class="col-sm-2 col-md-2">
             <label for="CargoAsesores" class="etiquetaSimple"><span class="badge pull-right" id="spanCargoAsesores"></span>Cargo Asesores:</label>
                <input type="text" name="Asesores" id="Asesores" class="form-control input-sm" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.00" onchange="Suma()">              
           </div>


             <div class="col-sm-2 col-md-2">
             <label class="etiquetaSimple"><span class="badge pull-right" id="spanCargoEspeciales"></span>Cargos Especiales:</label>
              <div class="agregasto">
              <input type="text" name="CargoGes" id="CargoGes" class="form-control input-sm" placeholder="$0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="0.00" onchange="Suma()" disabled><i class="fas fa-plus-circle"></i>           
              <input type="hidden" id="ccc" name="ccc">
              <input type="hidden" id="cco" name="cco">
              <input type="hidden" id="inversion" name="inversion">
              <input type="hidden" id="estrategia" name="estrategia">
              </div>  

           </div>
         </div>
         <div class="row" style="margin-top: 1%" id="motivoCambioPorcentajeDiv">

           <div class="col-sm-12 col-md-12"><input type="text" name="motivoCambioPorcentajeInput" id="motivoCambioPorcentajeInput" placeholder="MOTIVO DEL CAMBIO DE PORCENTAJE" class="form-control"></div>
         </div>
         <div class="row">
        <div class="col-sm-3 col-md-3">
             <label for="selectTipoGasto" class="etiquetaSimple">Tipo gasto:</label>
                <select name='selectTipoGasto' class="form-control">
                  <option value='1'>Operacional</option>
                  <option value='2'>Nomina</option>
                  <option value='3'>Fijo</option>
                </select>
           </div>
 
            


            <div class="col-sm-3 col-md-3" >
             <label for="CargoFianzas" class="etiquetaSimple">Total a Pagar:</label>
                <input type="text" name="CargoTotalconIVA" id="CargoTotalconIVA" class="form-control input-sm"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  required="" >              
           </div><br>
           <input type="hidden" id="textContieneNotasParaFacturar" name="textContieneNotasParaFacturar"> 
           <div class="col-sm-3 col-md-3" style="margin-top: 21px"><input type="button" class="btn btn-primary " name="button" id="button" value="Guardar" align="left"  onclick="enviarForm(event)"></div>                   

          
        </div><br>
        <div class="row"><div class="col-sm-3 col-md-3" ><h3><span class="label label-primary">Monto de Mes:</span><label class="label label-warning" id="montoMesLabel"></label></h3></label></div><div class="col-sm-3 col-md-3" ><h3><label class="label label-primary">Monto Autorizado:</label><label class="label label-warning" id="montoMesAutorizadoLabel"></label></h3></div><div class="col-sm-3 col-md-3" ><h3><label class="label label-primary">Monto Disponible:</label><label class="label label-warning label-lg" id="montoDisponibleLabel"></label></h3></div></div>
      </div>
  <div class="col-md-3 col-sm-3 col-xs-3"> 
        
 </div>
  </form >      
 </section>    
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
  </br>
  <hr />   
 </section>    


<section><button class="btn btn-danger" onclick="eliminarFactura('')">ELIMINAR FACTURA</button> <hr></section>

<section class="container-fluid breadcrumb-formularios">      

         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>

         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>           
              
   <div class="col-md-3 col-sm-3 col-xs-3">         
                      <div class="row">
                            
                      </div>

  </div>

  <div class="col-md-3 col-sm-3 col-xs-3">  
  
  </div>      
           
 </section>



<section class="container-fluid breadcrumb-formularios">

<div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>

    <div  id="DivMainContent1">
        <!-- Modificado [Suemy][2024-10-17] -->
                    <div class="table-responsive">
						<table class="table table-striped" id='Mitabla'>
							<thead>
		              <tr>
                  <th>Editar</th>
                  <th>Id</th>
                  <th>Fecha Factura</th>
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
								</tr>
							</thead>
							<tbody id="bodyTabla">   
							<?php if($Listafacturas != FALSE) {
                foreach ($Listafacturas->result() as $row){?>
                <tr onclick="escogerRow(this)" data-idfactura="<?=$row->id?>" id="<?=$row->id?>">
                  <td><? if($row->validada=='0') { ?>
                                              <button class="btn btn-primary" onclick="datosDeFacturaEFG('',<?php echo $row->id?>);abrirCerrarEditarFactura(true)">Editar</button>
                                             <!--a href="<?=base_url()?>presupuestos/editFactura?IDFact=<?php echo $row->id?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Editar</a-->
                    <?   } ?>
                  </td>
                                            <td><?=$row->id?></td>
                                            <td id="rowFechaFactura<?=$row->id?>"><?=$row->fecha_factura?></td> 
		                                      	<td id="rowFolioFactura<?=$row->id?>"><?=$row->folio_factura?></td>
                                            <td id="rowConcepto<?=$row->id?>"><?=$row->concepto?></td>
                  <td id="rowTotalFactura<?=$row->id?>">$<?=$row->totalfactura?></td>
                                            <td id="rowTotalConIva<?=$row->id?>">$<?=$row->totalconiva?></td>
                                            <td><? if($row->autorizadireccion > '0'){ echo 'AUTORIZADO';}else  {   echo 'PENDIENTE';}?></td>
                                            <td><?if($row->pagado > '0'){ echo 'PAGADO';}else{echo 'PENDIENTE';}?></td>
                                            <td><?=$row->fecha_pago?></td>
                                            <td id="rowNombreProveedor<?=$row->id?>"><? echo $this->capsysdre->GetNombreProveedor($row->idProveedor) ?></td>
                  <td id="filePDF<?=$row->id?>">        
                                              <?php if($row->archivoNombrePDF!=""){ ?>
                      <div class="col-md-12 container-downloadFile">
                        <select class="form-control input-sm dropdownFile">
                                                  <option value=<?php echo('"'.base_url().'ArchivosPresupuesto/'.$row->id.'/'.$row->archivoNombrePDF.'"') ?>>Descargar</option>                                             
                                                  <option value=<?php echo('"'.$row->archivoNombrePDF.'"') ?> >Eliminar</option>
                                                </select>
                        <button type="button" class="btn-OK" data-id="<?=$row->id?>" onclick="opcionesArchivo(this)">OK</button>
                      </div>
                                              <?php }else{ ?>
                                              <div class="divContenedor">
                        <form action="<?php echo(base_url().'presupuestos/GuardarArchivo/')?>" id="GuardarArchivo<?=$row->id?>" enctype="multipart/form-data"  method="post">
                                                <input type="hidden" value=<?php echo('"'.$row->id.'"') ?> name="id">
                          <input type="hidden" value="pdf" name="tipo">
                          <input type="file" name="Archivo"  class="Archivo1" onchange="if(!this.value.length)return false; uploadFile('<?=$row->id?>','PDF');"> 
                          <label class="subir-pdf" for="file">Agregar PDF</label>
                                              </form>
                      </div>
                    <?php } ?>
                  </td>
                  <td id="fileXML<?=$row->id?>">
                                              <?php if($row->archivoNombreXML!=""){ ?>
                      <div class="col-md-12 container-downloadFile">
                        <select class="form-control input-sm dropdownFile">
                                                  <option value=<?php echo('"'.base_url().'ArchivosPresupuesto/'.$row->id.'/'.$row->archivoNombreXML.'"') ?>>Descargar</option>                                             
                                                  <option value=<?php echo('"'.$row->archivoNombreXML.'"') ?> >Eliminar</option>
                                                </select>
                        <button type="button" class="btn-OK" data-id="<?=$row->id?>" onclick="opcionesArchivo(this)">OK</button>
                      </div>
                                              <?php }else{ ?>
                                              <div class="divContenedor">
                        <form action="<?php echo(base_url().'presupuestos/GuardarArchivo/')?>" id="GuardarArchivo<?=$row->id?>" enctype="multipart/form-data"  method="post"  >
                                                <input type="hidden" value=<?php echo('"'.$row->id.'"') ?> name="id"> 
                                                <input type="hidden" value="xml" name="tipo">
                          <input type="file" name="Archivo"  class="Archivo1"  onchange="if(!this.value.length)return false; uploadFile('<?=$row->id?>','XML');">
                          <label class="subir-xml" for="file">Agregar XML</label>
                                              </form>
                      </div>
                    <?php } ?>
                  </td>
                                          <td id="rowFormaPago<?=$row->id?>"><?
                                                if($row->posteriorapago=='0'){echo "Factura Pospuesta";} 
                                                if($row->posteriorapago=='1'){echo "Factura Normal"; }
                                                 if($row->posteriorapago=='2'){echo "Caja Chica"; }
                                                if($row->posteriorapago=='3'){echo "Toka";  }
                                                if($row->posteriorapago=='4'){echo "Amex"; }
                                                if($row->posteriorapago=='5'){echo "Nomina y Otros";     }
                                                if($row->posteriorapago=='9'){echo "DINNERCAP";     }
                                                  ?></td>     

										</tr>
							<?php
									}
								}
							?>
							</tbody>
                <?if($totalResultados == 0){?>
                  <tfoot><tr><td colspan="4"><center><b>No se encontraron registros.</b></center></td></tr></tfoot>
            <? } ?>
						</table>
               		</div>
        <!--  -->
    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>

 <div class="row"><div class="col-md-12" style="font-size: 1.5rem;"><i>Total de resultados: <b><?=$totalResultados?></b></i></div></div>

</section>
<div id="divModalGenerico" class="modalCierra">

    <div id="divModalContenidoGenerico" class="modal-contenido"  >
      <div class="row">
      <div class="col-md-12 col-sm-12">
      <button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;position: relative;left: 95%">X</button>
      </div>  
    </div>
  <div class="row">
    <div class="col-md-12 col-sm-12"><label class="etiquetaSimple">Modo de Pago</label><select id="selectFormasPago" class="form-control" onchange="cambiarFormPago(this)"></select></div>
  </div>    
  <div class="row">
  <div class="col-md-12 col-sm-12"><label class="etiquetaSimple">Descripcion</label><input type="text" id="notasDescripcio" class="form-control"></div>
  </div>
  <div class="row">
  <div class="col-md-3 col-sm-3"><label class="etiquetaSimple">Cargo Fianzas</label><input type="text" id="notasCargoFianzas" class="form-control"></div>
  <div class="col-md-3 col-sm-3"><label class="etiquetaSimple">Cargo Seguros</label><input type="text" id="notasCargoSeguros" class="form-control"></div>
  <div class="col-md-3 col-sm-3"><label class="etiquetaSimple">Cargo Coorporativo</label><input type="text" id="notasCargoCoorporativos" class="form-control"></div>
  <div class="col-md-3 col-sm-3"><label class="etiquetaSimple">Cargo Especiales</label><input type="text" id="notasCargoEspeciales" class="form-control"></div>
  </div>
  <div class="row">
    <div class="col-md-3 col-sm-3"><label class="etiquetaSimple">Fecha</label><input type="text" id="fechaNota"  class="form-control fecha"></div>
  <div class="col-md-3 col-sm-3"><label class="etiquetaSimple">Subtotal</label><input type="text" id="notasTotal" class="form-control"></div>

  <div class="col-md-3 col-sm-3"><br><button class="btn btn-success" onclick="guardarNota('')">Guardar Nota</button></div>
</div>
<hr>
<div class="row">
  <div class="col-md-12 col-sm-12">
  <table class="table"><thead><tr><th>Forma de pago</th><th>Numero tarjeta</th><th>Descripcion</th><th>fecha Compra</th><th>Fianzas</th><th>Seguros</th><th>Coorporativo</th><th>Especiales</th><th>Monto de Compra</th><th></th></tr></thead>
  <tbody id="tbodyNotas">
    
  </tbody>
  </table>
  </div>
  
</div>
</div>

</div>
<div id="divModalParaFacturar" class="modalCierra">
    <div id="divModalContenidoParaFacturar" class="modal-contenido"  >
      <div class="row"><div class="col-md-12 col-sm-12"><button onclick="cerrarModal('divModalParaFacturar')" style="color: white;background-color:red; border:double;position: relative;left: 90%">X</button></div></div>
      <div class="row">
      <div class="col-md-3 col-sm-3"><select id="selectPersonasConNotas" class="form-control"></select></div>
      <div class="col-md-3 col-sm-3"><button class="btn btn-success" onclick="traerNotasDePersonas('')">Traer notas</button></div>
      <div class="col-md-3 col-sm-3"><button class="btn btn-success" onclick="llevarNotasParaFacturar('')">Llevar notas a factura</button></div>      
    </div>
    <hr>
    <div class="row">
    <div class="col-md-12 col-sm-12">
      <table class="table"><thead><tr><th>Forma de pago</th><th>Numero tarjeta</th><th>Descripcion</th><th>fecha Compra</th><th>Fianzas</th><th>Seguros</th><th>Coorporativo</th><th>Especiales</th><th>Para facturar</th><th></th></tr></thead>
        <tbody id="tbodyNotasPersona">    </tbody>
     </table>
     </div>|
    </div>
 </div>
</div>
  <style type="text/css">
 .EtiquetaFile{position: relative; top: 30px; width: 150px; border: solid; ;}
 .Archivo1{opacity: 0; width: 150px}
 .divContenedor{width: 150px}
  /*.divContenedor:hover label{background:#d8d8d8}*/ /* [Suemy][2024-10-17] */ 
  body{overflow: scroll;}
  .modal-contenido{background-color:white;width:95%;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000;overflow: auto; }
  .modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
  .modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
  <style>
</style>

 </style>
<?php $this->load->view('footers/footer'); ?>


<div id="modalModifcaFactura" style="display: flex;flex-direction: column;" >
  <div style="background:#007bff;display: flex;margin-left: 2%;flex-direction: row-reverse;margin-right: 2%"><button onclick="abrirCerrarEditarFactura()" style="background-color: red;color: white">X</button></div>
  <div id="modalcontenidoFactura" class="modal-contenido"  >
   <?php $this->load->view('presupuestos/editarFacturaGeneral');?>
  </div> 

</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">
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


/*$("#formreferidos").submit(function(e){
  e.preventDefault();
  //buscamos resultados del proveedor
  let proveedor = document.querySelector('provee').value;
  console.log(proveedor);
}*/
eventListeners();
function eventListeners(){
  document.querySelector('.btnGrabaproveedor').addEventListener('click',actualizaProveedores);
  document.querySelector('.agregasto').addEventListener('click',llamagastoEspecial);
  document.querySelector('.grabaGastos a').addEventListener('click',enviaCargos);
}
function enviaCargos(e)
{
   e.preventDefault();
   let gastoCCC= document.querySelector("#gastosCcc").value;
   let gastoCCo=document.querySelector("#gastosCco").value;
   let gastoCCInst=document.querySelector("#gastosInst").value;
   let gastoEstrategia=document.querySelector("#gastosEstrategia").value;
   
    $('#ccc').val(gastoCCC);
    $('#cco').val(gastoCCo);
    $('#inversion').val(gastoCCInst);
    $('#estrategia').val(gastoEstrategia);
   if(gastoCCC==""){gastoCCC=0.0;}
   if(gastoCCo==""){gastoCCC=0.0;}
   if(gastoCCInst==""){gastoCCC=0.0;}
   if(gastoEstrategia==""){gastoEstrategia=0.0;}

   $(".modalGastos").fadeOut();
   let total = parseFloat(gastoCCC)+ parseFloat(gastoCCo) + parseFloat(gastoCCInst)+parseFloat(gastoEstrategia);
   $('#CargoGes').val(total);
   Suma();

}
function llamagastoEspecial(e)
{
  //console.log(e.target);
  if(e.target.classList.value=='fas fa-plus-circle')
  {
    //console.log('hiciste clic');
    $(".modalGastos").fadeIn();
  }
}
function actualizaProveedores(e)
{
  e.preventDefault();
  //console.log(e);
 let nombreprovedor = $("#mproveedor").val();
 let dias =      $("#mdias").val(); 
 let clave =      $("#mclave").val(); 
 let cuenta =       $("#mcuenta").val();
 let banco =     $("#mbanco").val();
 let direccion =      $("#mdireccion").val(); 
 let correo =      $("#mcorreo").val();
 let celular =      $("#mcelular").val();
 let contacto =     $("#mcontacto").val();
 let telefono =     $("#mtelefono").val();
 let extencion =     $("#mextencion").val();
 let giro =      $("#mgiro").val();
 let id =      $("#idprovee").val();
//console.log(nombreprovedor);
 if(nombreprovedor =="")
 {
  document.getElementById('mproveedor').focus();
  Swal.fire(
         'Giro!',
         'El giro del Cliente Esta Vacio',
         'warning'
      );   
 }
if(contacto == "")
{
 document.getElementById('mcontacto').focus();
      Swal.fire(
         'Contacto!',
         'El Contacto Esta Vacio',
         'warning'
      );   
 return false;
}
//telefono
if(telefono == "")
{
document.getElementById('mtelefono').focus();
      Swal.fire(
         'Telefono!',
         'El Telefono Esta Vacio',
         'warning'
      );   
 return false;
}
//Extencion
if(extencion == "")
{
 document.getElementById('mextencion').focus();
      Swal.fire(
         'Extencion!',
         'La Extencion Esta Vacio',
         'warning'
      );   
 return false;
}
//celular
if(celular == "")
{
 document.getElementById('mcelular').focus();
      Swal.fire(
         'Celular!',
         'El celular Esta Vacio',
         'warning'
      );   
 return false;
}
 //email""
 if(correo == "")
{
 document.getElementById('mcorreo').focus();
      Swal.fire(
         'email!',
         'El email Esta Vacio',
         'warning'
      );   
 return false;
}
  //direccion
  if(direccion == "")
{
 document.getElementById('mdireccion').focus();
      Swal.fire(
         'direccion!',
         'La direccion Esta Vacio',
         'warning'
      );   
 return false;
}
  //banco
  if(banco == "")
{
 document.getElementById('mbanco').focus();
      Swal.fire(
         'banco!',
         'El Banco Esta Vacio',
         'warning'
      );   
 return false;
}
//cuenta
if(cuenta == "")
{
 document.getElementById('mcuenta').focus();
      Swal.fire(
         'cuenta!',
         'La Cuenta Esta Vacio',
         'warning'
      );   
 return false;
} 
//clave 
if(clave == "")
{
 document.getElementById('mclave').focus();
      Swal.fire(
         'clave!',
         'La clave Esta Vacio',
         'warning'
      );   
 return false;
}
 //dias 
 if(dias == "")
{
 document.getElementById('mdias').focus();
      Swal.fire(
         'dias de Credito!',
         'El dia de credito Esta Vacio',
         'warning'
      );   
 return false;
}


if(giro == "")
{
 //document.getElementById('mgiro').focus();
      Swal.fire(
         'Giro!',
         'El Nombre del giro esta Vacio',
         'warning'
      );   
 return false;
}
//Actualizamos Proveedores
 xhr = new XMLHttpRequest();
 datos = new FormData();
 datos.append('nombreprovedor',nombreprovedor);
 datos.append('dias',dias);
 datos.append('clave',clave);
 datos.append('cuenta',cuenta);
 datos.append('banco',banco);
 datos.append('direccion',direccion);
 datos.append('correo',correo);
 datos.append('celular',celular);
 datos.append('contacto',contacto);
 datos.append('telefono',telefono);
 datos.append('extencion',extencion);
 datos.append('giro',giro);
 datos.append('id',id);
 xhr.open('POST',"<?php echo base_url();?>presupuestos/actualizadatosProveedor",true);
 xhr.onload=function()
 {
   if(this.status ===200)
   {
     var respuesta = JSON.parse(xhr.responseText);
     console.log(respuesta);
   }
 }
 xhr.send(datos);
 Swal.fire(
         'Actualizado!',
         'El Proveedor ha sido Actualizado',
         'success'
       )
       cierraModalfecha();
//Termina Actualizacion
}
/************************************** */
function quitarListaParaFacturar(objeto)
{
  let row=objeto.parentNode.parentNode;
  let index=row.rowIndex;
  let fianzas=row.getAttribute('data-fianzas');
  let seguros=row.getAttribute('data-seguros');
  let coorporativo=row.getAttribute('data-coorporativo');
  let especial=row.getAttribute('data-especial');
  let monto=row.getAttribute('data-monto');
  document.getElementById('CargoFianzas').value=parseFloat(document.getElementById('CargoFianzas').value)-parseFloat(fianzas);
  document.getElementById('CargoInst').value=parseFloat(document.getElementById('CargoInst').value)-parseFloat(seguros);
  document.getElementById('Corporativos').value=parseFloat(document.getElementById('Corporativos').value)-parseFloat(coorporativo);

document.getElementById('CargoGes').value=parseFloat(document.getElementById('CargoGes').value)-parseFloat(especial);

document.getElementById('CargoTotal').value=parseFloat(document.getElementById('CargoTotal').value)-parseFloat(monto);

  document.getElementById('tableConNotasParaFacturar').deleteRow(index);
  
}
function llevarNotasParaFacturar()
{
  document.getElementById('divContieneNotasParaFacturar').innerHTML='';
  let facturar=document.getElementsByName('checkParaFacturar');
  let cant=facturar.length;

  let rowTabla='<table class="table" id="tableConNotasParaFacturar">';
  let fianzasTotal=0;
  let segurosTotal=0;
  let coorporativoTotal=0;
  let especialTotal=0;
  let montoTotal=0;
  for(let i=0;i<cant;i++)
  {
    if(facturar[i].checked)
    {
      let fianzas=facturar[i].parentNode.parentNode.getAttribute('data-fianzas');
      let seguros=facturar[i].parentNode.parentNode.getAttribute('data-seguros');
      let coorporativo=facturar[i].parentNode.parentNode.getAttribute('data-coorporativo');
      let especial=facturar[i].parentNode.parentNode.getAttribute('data-especial');
      let monto=facturar[i].parentNode.parentNode.getAttribute('data-monto');
      let id=facturar[i].parentNode.parentNode.getAttribute('data-idnotascompra');
      rowTabla=rowTabla+'<tr data-fianzas="'+fianzas+'" data-seguros="'+seguros+'" data-coorporativo="'+coorporativo+'" data-especial="'+especial+'" data-monto="'+monto+'" data-idnotascompra="'+id+'">'+facturar[i].parentNode.parentNode.innerHTML+'</tr>';
      fianzasTotal=parseFloat(fianzasTotal)+parseFloat(fianzas);
      segurosTotal=parseFloat(segurosTotal)+parseFloat(seguros);
      coorporativoTotal=parseFloat(coorporativoTotal)+parseFloat(coorporativo);
      especialTotal=parseFloat(especialTotal)+parseFloat(especial);
      montoTotal=parseFloat(montoTotal)+parseFloat(monto);
    }
  }
  rowTabla=rowTabla+'</table>';  
  document.getElementById('divContieneNotasParaFacturar').innerHTML=rowTabla;  
  document.getElementById('CargoFianzas').value=fianzasTotal;
  document.getElementById('CargoInst').value=segurosTotal;
  document.getElementById('Corporativos').value=coorporativoTotal;
  document.getElementById('CargoGes').value=especialTotal;
  document.getElementById('CargoTotal').value=montoTotal;
  console.log(document.getElementById('tableConNotasParaFacturar').rows[0].cells[9].innerHTML);
  let cantNotas=document.getElementById('tableConNotasParaFacturar').rows.length;
  for(let i=0;i<cantNotas;i++)
  {
    document.getElementById('tableConNotasParaFacturar').rows[i].cells[9].innerHTML='<button class="btn btn-danger" onclick="quitarListaParaFacturar(this)">X</button>';
  }
 cerrarModal('divModalParaFacturar');
}
function traerNotasDePersonas(datos)
{
  if(datos=='')
  {
    let params='';
    {
      let facturar=document.getElementsByName('checkParaFacturar');
      let cant=facturar.length;
    }
   params=params+'idPersona='+document.getElementById('selectPersonasConNotas').value;
   controlador="contabilidad/traerNotasDePersonas/?";
   peticionAJAX(controlador,params,'traerNotasDePersonas');   

  }
  else
  {
    pintarTablaNotas(datos.notas,'tbodyNotasPersona',1);
    console.log(datos)
  }
}
function buscarPersonasConNotas(datos)
{
  if(datos=="")
  {
    let params='';
   controlador="contabilidad/buscarPersonasConNotas/";
   document.getElementById('tbodyNotasPersona').innerHTML='';
    peticionAJAX(controlador,params,'buscarPersonasConNotas');   
    cerrarModal('divModalParaFacturar');
    
  }
  else{dibujaSelectPersonasConNotas(datos.personasConNotas); }
}
function dibujaSelectPersonasConNotas(datos)
{
 let option='';
 let cant=datos.length;
 for(let i=0;i<cant;i++)
 {
  option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].apellidoPaterno+' '+datos[i].apellidoMaterno+' '+datos[i].nombres+'</option>';
 }
 document.getElementById('selectPersonasConNotas').innerHTML=option;
}
function borrarNotas(datos,idNota=null)
{
  if(datos=='')
  {
    let params='';
   params=params+'idNotasCompra='+idNota;
   controlador="contabilidad/borrarNotas/?";
   peticionAJAX(controlador,params,'borrarNotas');   

  }
  else
  {
    alert(datos.mensaje);
    pintarTablaNotas(datos.notas,'tbodyNotas',0);
  }
}  
function guardarNota(datos)
{
 if(datos=='')
 {
   let params='';
   params=params+'idFormaPago='+document.getElementById('selectFormasPago').value;
   params=params+'&notasDescripcion='+document.getElementById('notasDescripcio').value;
   params=params+'&notasCargoFianzas='+document.getElementById('notasCargoFianzas').value;
   params=params+'&notasCargoEspeciales='+document.getElementById('notasCargoEspeciales').value;
   params=params+'&notasTotal='+document.getElementById('notasTotal').value;
   params=params+'&notasCargoCoorporativos='+document.getElementById('notasCargoCoorporativos').value;
   params=params+'&fechaNota='+document.getElementById('fechaNota').value;
   params=params+'&notasCargoSeguros='+document.getElementById('notasCargoSeguros').value;
   controlador="contabilidad/guardarNota/?";
   peticionAJAX(controlador,params,'guardarNota');   
 }
 else
 {
  alert(datos.mensaje);
  pintarTablaNotas(datos.notas,'tbodyNotas',0); 
  inicializaNotas();
 }
}  
function pintarTablaNotas(notas,tabla,paraFacturar=null)
{
 let cant=notas.length;
 let row='';
  let cargoFianzas=0;
  let cargoSeguros=0;
  let cargoCoorporativo=0;
  let cargoEspecial=0;
  let monto=0;
 for(let i=0;i<cant;i++)
 {
  cargoFianzas=parseFloat(cargoFianzas)+parseFloat(notas[i].cargoFianzas);
  cargoSeguros=parseFloat(cargoSeguros)+parseFloat(notas[i].cargoSeguros);
  cargoCoorporativo=parseFloat(cargoCoorporativo)+parseFloat(notas[i].cargoCoorporativo);
  cargoEspecial=parseFloat(cargoEspecial)+parseFloat(notas[i].cargoEspecial);
  monto=parseFloat(monto)+parseFloat(notas[i].montoCompra);
  row=row+'<tr data-fianzas="'+notas[i].cargoFianzas+'" data-seguros="'+notas[i].cargoSeguros+'" data-coorporativo="'+notas[i].cargoCoorporativo+'" data-especial="'+notas[i].cargoEspecial+'" data-monto="'+notas[i].montoCompra+'" data-idnotascompra="'+notas[i].idNotasCompra+'">';
  row=row+'<td>'+notas[i].formaPago+'</td>';
  row=row+'<td>'+notas[i].numeroTarjeta+'</td>';
  row=row+'<td>'+notas[i].descripcionCompras+'</td>';
  row=row+'<td>'+notas[i].soloFecha+'</td>';  
  row=row+'<td>'+notas[i].cargoFianzas+'</td>';
  row=row+'<td>'+notas[i].cargoSeguros+'</td>';
  row=row+'<td>'+notas[i].cargoCoorporativo+'</td>';
  row=row+'<td>'+notas[i].cargoEspecial+'</td>';
  row=row+'<td>'+notas[i].montoCompra+'</td>';
  if(paraFacturar==1){row=row+'<td><input type="checkbox" value="'+notas[i].idNotasCompra+'" name="checkParaFacturar" checked></td>';}    
  else{row=row+'<td><button onclick="borrarNotas(\'\','+notas[i].idNotasCompra+')" class="btn btn-danger">X</button></td>';}
  row=row+'</tr>'

 }
 row=row+'<tr>';
  row=row+'<td>Totales</td>';
  row=row+'<td></td>';
  row=row+'<td></td>';
  row=row+'<td></td>';  
  row=row+'<td>'+cargoFianzas+'</td>';
  row=row+'<td>'+cargoSeguros+'</td>';
  row=row+'<td>'+cargoCoorporativo+'</td>';
  row=row+'<td>'+cargoEspecial+'</td>';
  row=row+'<td>'+monto+'</td>';
  row=row+'<td></td>';
  row=row+'</tr>'

 document.getElementById(tabla).innerHTML=row;
}
function cambiarFormPago(objeto)
{
  let index=objeto.selectedIndex;
  let especial=objeto.options[index].getAttribute('data-especial');
  if(especial==0)
  {
    document.getElementById('notasCargoFianzas').removeAttribute('disabled');
    document.getElementById('notasCargoSeguros').removeAttribute('disabled');
    document.getElementById('notasCargoCoorporativos').removeAttribute('disabled');
    document.getElementById('notasCargoEspeciales').setAttribute('disabled','true');
  }
  else
  {
    document.getElementById('notasCargoFianzas').setAttribute('disabled','true');
    document.getElementById('notasCargoSeguros').setAttribute('disabled','true');
    document.getElementById('notasCargoCoorporativos').setAttribute('disabled','true');
    document.getElementById('notasCargoEspeciales').removeAttribute('disabled');
  }
  inicializaNotas();
}
function traerFormasPagos(datos)
{
  if(datos=='')
  {
    let params='';
   //params=params+'comentario='+document.getElementById('comentarioParaAN').value;   
   controlador="contabilidad/traerFormasPagos/?";
    peticionAJAX(controlador,params,'traerFormasPagos');   
    //cerrarModal('divModalGenerico');
  }
  else
  {
   
   let cant=datos.tarjetas.length;
   let option='<option value="0">TARJETAS ASIGNADAS</option>';
   for(let i=0;i<cant;i++)
   {
    if(datos.tarjetas[i].esTarjetaEspecial==1)
    {
     option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'</option>';
    }
    else{

      option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'" data-especial="'+datos.tarjetas[i].esTarjetaEspecial+'">'+datos.tarjetas[i].numeroTarjeta+'('+datos.tarjetas[i].formaPago+')</option>';}
   }
    //document.getElementById('selectFormasPago').innerHTML=option;
    document.getElementById('selectTarjetasCredito').innerHTML=option;

   
   //inicializaNotas();
     //  document.getElementById('notasCargoFianzas').setAttribute('disabled','true');
    //document.getElementById('notasCargoSeguros').setAttribute('disabled','true');
    //document.getElementById('notasCargoCoorporativos').setAttribute('disabled','true');
    //document.getElementById('notasCargoEspeciales').setAttribute('disabled','true');
    //pintarTablaNotas(datos.notas,'tbodyNotas',0);
  }
}
function inicializaNotas()
{
     document.getElementById('notasCargoFianzas').value=0;
   document.getElementById('notasCargoEspeciales').value=0;
   document.getElementById('notasTotal').value=0;
   document.getElementById('notasCargoSeguros').value=0;
   document.getElementById('notasCargoCoorporativos').value=0;
}
function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         window[funcion](respuesta);                                                          
      }     
   }
  };
 req.send(parametros);
}

function cerrarModal(modal)
{
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}

function cierraModalfecha()
 {
  $(".modalProveedoor").fadeOut();
 }
 function cierraModalgasto()
 {
  $(".modalGastos").fadeOut();
 }
function enviarForm(event){  
event.preventDefault()
var proveedor=document.querySelector('#provee').value;
if(proveedor==''){alert('SELECCIONAR UN PROVEEDOR');return 0;}
if(document.getElementById('selectMetodoDePago').value==''){alert('SELECCIONAR UNA FORMA DE PAGO');return 0;}
//console.log(proveedor);
//huricm12-03-21
var nombreprovedor="";
var contacto="";
var telefono="";
var extencion="";
var correo="";
var celular="";
var direccion="";
var banco="";
var cuenta="";
var dias="";
var giro="";
var clave="";
var apertura = document.querySelector('#AperturaConta').value;
//console.log(apertura);
 var ano = document.getElementById('1fNacimiento').value;//document.querySelector('#1fNacimiento').value;
 fecha = new Date(ano);
 var anofactura = fecha.getFullYear();
 //ano =ano.getYear();
 //console.log(anofactura);
var xhr = new XMLHttpRequest();
var datos = new FormData();
datos.append('id',proveedor);
datos.append('apertura',apertura);
xhr.open('POST',"<?php echo base_url();?>presupuestos/verificaProveedor")
xhr.onload=function(){
  if(xhr.status === 200)
  {
    respuesta = JSON.parse(xhr.responseText);
     nombreprovedor=respuesta['provedores'][0].NombreProveedor;
     contacto=respuesta['provedores'][0].Nombre_contacto;
     telefono=respuesta['provedores'][0].telefono1;
     extencion=respuesta['provedores'][0].extension;
     celular=respuesta['provedores'][0].telefono_movil;
     direccion=respuesta['provedores'][0].direccion;
     banco=respuesta['provedores'][0].banco;
     cuenta=respuesta['provedores'][0].cuenta;
     dias=respuesta['provedores'][0].DiasCredito;
     giro=respuesta['provedores'][0].giroProveedor;
     correo=respuesta['provedores'][0].email;    
     clave=respuesta['provedores'][0].clabe;    
     if(nombreprovedor=="" || contacto=="" ||telefono==""||extencion==""||celular==""||direccion==""||banco==""||cuenta==""||dias==""||correo==""||giro=="")
     {
      //console.log(nombreprovedor);
      $("#mproveedor").val(nombreprovedor);
      $("#mcontacto").val(contacto);
      $("#mtelefono").val(telefono);
      $("#mextencion").val(extencion);
       $("#mcelular").val(celular);
       $("#mcorreo").val(correo);
       $("#mdireccion").val(direccion);
      $("#mbanco").val(banco);
        $("#mcuenta").val(cuenta);
       $("#mclave").val(clave);
       $("#mdias").val(dias); 
       $("#mgiro").val(giro);
       $("#idprovee").val(proveedor);
       $(".modalProveedoor").fadeIn();
      }
      else
      {
        var formulario=document.getElementById('formreferidos');
        var tipoPago=document.getElementById('selectMetodoDePago').value;
        var bandSubmit=1;
        var folio = document.getElementById('folio').value;var fechas = document.getElementById('1fNacimiento').value;
        if(tipoPago!='')
      {
         if(tipoPago==3)
         {        
             if(folio !='' && fechas!=''){bandSubmit=1; }  
            else{alert('No capturaste FOLIO O FECHA DE FACTURA');} 
         }
       if(tipoPago==0){bandSubmit=1;}
       if(tipoPago==1 || tipoPago==2 || tipoPago==4 || tipoPago==5 || tipoPago==9 )
       { 
        if(fechas!=''){bandSubmit=1;}  
        else{alert('No capturaste Fecha de Factura o Documento');} 
       }
      }
var id="";
 if(id!=""){elementosFormulario[id].focus();}
 else
 {let cadena='';
   if(document.getElementById('tableConNotasParaFacturar'))
  { 
    let cant=document.getElementById('tableConNotasParaFacturar').rows.length;    
    for(let i=0;i<cant;i++){cadena=cadena+document.getElementById('tableConNotasParaFacturar').rows[i].getAttribute('data-idnotascompra')+',';}
  }
  //Comprobamoos si las factura a capturar correponde al año
  
  
  //Termina comprobacion
  document.getElementById('textContieneNotasParaFacturar').value=cadena;
    var combo = document.getElementById("idCuentaContable");
    var selected = combo.options[combo.selectedIndex];
    
    let autorizado=parseFloat(selected.getAttribute('data-autorizadomes'))+parseFloat(CargoTotal.value);
    if(parseFloat(autorizado)>parseFloat(selected.getAttribute('data-montomes'))){alert('Ya se supero el limite mensual')}
  
  let fianzasDefault=document.createElement('input');
  let institucionalDefault=document.createElement('input'); 
  let coorporativoDefault=document.createElement('input')
  let asesoresDefault=document.createElement('input');
  let gestionDefault=document.createElement('input');

     fianzasDefault.type='hidden';
     institucionalDefault.type='hidden';
     coorporativoDefault.type='hidden';
     asesoresDefault.type='hidden';
     gestionDefault.type='hidden';

     
     fianzasDefault.name='fianzasDefault';
     institucionalDefault.name='institucionalDefault';
     coorporativoDefault.name='coorporativoDefault';
     asesoresDefault.name='asesoresDefault';
     gestionDefault.name='gestionDefault';
     fianzasDefault.value=porcentajesGlobales.fianzas;
     institucionalDefault.value=porcentajesGlobales.institucional;
     coorporativoDefault.value=porcentajesGlobales.coorporativo;
     asesoresDefault.value=porcentajesGlobales.asesores;
     gestionDefault.value=porcentajesGlobales.gestion;



    formulario.append(fianzasDefault);
    formulario.append(institucionalDefault);
    formulario.append(coorporativoDefault);
    formulario.append(asesoresDefault);
    formulario.append(gestionDefault);
  formulario.submit();

  //agregaAutomatico('Verifica La Factura x234','23','Jose Perez','ejemplo@hotmail.com');
 }

       }
  }
}
xhr.send(datos);
//event.currentTarget.submit();

//Temina
 
}
/****Agregamo Automatico*************/
function agregaAutomatico($tarea,$idusuario,$nombre,$correo){
  //var tarea =$tarea;// "Genera Correo Juan lopez"
  var xhr = new XMLHttpRequest();
  var datos = new FormData();
  datos.append('tarea',$tarea);
  datos.append('idusuario',$idusuario);
  datos.append('nombre',$nombre);
  datos.append('correo',$correo);
   xhr.open('POST',"<?php echo base_url();?>cproyecto/grabaTareaautomatica",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
                 //console.log(respuesta);
              }
            }
            xhr.send(datos);
           
} 
/****Agregamo Automatico*************/
function calcularMontoDisponible()
{
    var combo = document.getElementById("idCuentaContable");
    var selected = combo.options[combo.selectedIndex];    
    document.getElementById('montoMesLabel').innerHTML='$'+selected.getAttribute('data-montomes');
    document.getElementById('montoMesAutorizadoLabel').innerHTML='$'+selected.getAttribute('data-autorizadomes');
    document.getElementById('montoDisponibleLabel').innerHTML='$'+(parseFloat(selected.getAttribute('data-montomes'))-parseFloat(selected.getAttribute('data-autorizadomes'))).toFixed(2);

   
}
function calculaPagoDeCanal()
{
  let subtotal=document.getElementById('CargoTotal');
  let select=document.getElementById('idCuentaContable');
  let option= select.options[select.selectedIndex];
  document.getElementById('motivoCambioPorcentajeDiv').classList.add('verOcultar')
  document.getElementById('motivoCambioPorcentajeInput').value='';
 if(subtotal.value>0)
   {
    cargosManejoVista(false)
    let fianzas=option.getAttribute('data-fianzasporcentaje');
    let institucional=option.getAttribute('data-institucionalPorcentaje');
    let coorporativo=option.getAttribute('data-coorporativoPorcentaje');
    let gestion=option.getAttribute('data-gestionPorcentaje');
    let asesores=option.getAttribute('data-asesoresPorcentaje');
    let montoFianzas=0.00;
    let montoInstitucional=0.00;
    let montoCoorporativo=0.00;
    let montoGestion=0.00;
    let montoAsesores=0.00;
        document.getElementById('spanCargoFianzas').innerHTML=fianzas+'%';
    document.getElementById('spanCargoSeguros').innerHTML=institucional+'%';
    document.getElementById('spanCargoCoorporativo').innerHTML=coorporativo+'%';
    document.getElementById('spanCargoAsesores').innerHTML=asesores+'%';
    document.getElementById('spanCargoEspeciales').innerHTML=gestion+'%';
    if(fianzas>0){montoFianzas=(fianzas*subtotal.value)/100;}

    if(institucional>0){montoInstitucional=(institucional*subtotal.value)/100;}

    if(coorporativo>0){montoCoorporativo=(coorporativo*subtotal.value)/100;}

    if(asesores>0){montoAsesores=(asesores*subtotal.value)/100;}

    if(gestion>0){montoGestion=(gestion*subtotal.value)/100;}



     document.getElementById('CargoFianzas').value=montoFianzas.toFixed(2);
     porcentajesGlobales.fianzas=montoFianzas.toFixed(2);
     document.getElementById('CargoInst').value=montoInstitucional.toFixed(2);
     porcentajesGlobales.institucional=montoInstitucional.toFixed(2);
     document.getElementById('Corporativos').value=montoCoorporativo.toFixed(2);
     porcentajesGlobales.coorporativo=montoCoorporativo.toFixed(2);
     document.getElementById('Asesores').value=montoAsesores.toFixed(2);
     porcentajesGlobales.asesores=montoAsesores.toFixed(2);
     document.getElementById('CargoGes').value=montoGestion.toFixed(2)
     porcentajesGlobales.gestion=montoGestion.toFixed(2);
     document.getElementById('CargoTotalconIVA').value=subtotal.value; 
   }
   else{cargosManejoVista(true)}
   calcularMontoDisponible()
}
 
$(function () {$(".fecha").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});

function escogerRow(objeto)
{
  if(document.getElementsByClassName('rowSeleccionado')[0]){document.getElementsByClassName('rowSeleccionado')[0].classList.remove('rowSeleccionado');}
  objeto.classList.add('rowSeleccionado');
}
function eliminarFactura(datos='')
{
  if(datos=='')
  {
    if(document.getElementsByClassName('rowSeleccionado')[0])
   {
     let confirmacion=confirm("DESEAS ELIMINAR LA FACTURA "+document.getElementsByClassName('rowSeleccionado')[0].dataset.idfactura);
     if(confirmacion){    
     params="id="+document.getElementsByClassName('rowSeleccionado')[0].dataset.idfactura;        
     controlador="presupuestos/eliminarFactura/?";     
     peticionAJAX(controlador,params,'eliminarFactura');   
     }
   }   
    else{alert('SELECCIONE UNA FACTURA PARA ELIMINAR')}
  }
  else
  {
    if(!datos.status){alert(datos.mensaje)}
    else
    {
      let direccion='<?=base_url()?>presupuestos/Vistafacturas';
      window.location.replace(direccion);
    }
  }
}
</script>
<?php
function imprimirCuentasPorDepartamentos($informacion){

  $select='<select name="idCuentaContable" id="idCuentaContable" class="form-control input-sm" onchange="calculaPagoDeCanal()" required>';
  foreach ($informacion as $key => $value) 
  {
    $select.='<optgroup label="'.$key.'">';
    foreach ($informacion[$key] as  $valueDepartamento) 
    {
      $select.='<option value="'.$valueDepartamento->idCuentaContable.'" data-fianzasPorcentaje="'.$valueDepartamento->fianzasPorcentaje.'" data-institucionalPorcentaje="'.$valueDepartamento->institucionalPorcentaje.'" data-coorporativoPorcentaje="'.$valueDepartamento->coorporativoPorcentaje.'" data-gestionPorcentaje="'.$valueDepartamento->gestionPorcentaje.'" data-asesoresPorcentaje="'.$valueDepartamento->asesoresPorcentaje.'" data-montomes="'.$valueDepartamento->montoMes.'" data-autorizadomes="'.$valueDepartamento->autorizadoMes.'">'.$valueDepartamento->cuentaContable.'</option>';
    }
    $select.='</optgroup>';
  }
  $select.='</select>';
  return $select;
  

}
function imprimirPermisosFormaPago($array)
{
  $option='<option></option>';
  foreach ($array as  $value) 
  {
     $option.='<option value="'.$value->idFormaPago.'">'.$value->formaPago.'</option>';
  }
  return $option;
}
?>
<script type="text/javascript">
  calcularMontoDisponible();
  traerFormasPagos('');
  let porcentajesGlobales=new Object();
  porcentajesGlobales.fianzas=0;
  porcentajesGlobales.institucional=0;
  porcentajesGlobales.coorporativo=0;
  porcentajesGlobales.asesores=0;
  porcentajesGlobales.Especiales=0;

function cargosManejoVista(band=true)
{
document.getElementById("CargoFianzas").disabled=band;
document.getElementById("CargoInst").disabled=band;
document.getElementById("Corporativos").disabled=band;
document.getElementById("Asesores").disabled=band;

}

cargosManejoVista(true);
document.getElementById('motivoCambioPorcentajeDiv').classList.add('verOcultar')

  guardarEFG_BTN.addEventListener('click',function(){actualizarDatosFacturaEFG('actualizarTablaFactura')});

function actualizarTablaFactura(datos)
{
  console.log(datos)
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
abrirCerrarEditarFactura();

//---------------------------------------------------------------------------------------------------------

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
            Swal.fire(title,message,status);
        },
        error: (error) => {
            console.log(error);
            Swal.fire("¡Uups!", "Hay problemas al intentar guardar.", "error");
        }            
    })
  }
</script>