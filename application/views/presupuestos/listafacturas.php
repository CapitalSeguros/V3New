
<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
?>
<?php $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php $this->load->view('headers/menu');?>



<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


<script>
  
    // $( function(){$( "#1fNacimiento" ).datepicker({          
    //         dateFormat: 'yy-mm-dd',});} );
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!----------ING ROBERTO ALVAREZ 24/MARZO/2025--------->
<style>
    #FACTURASACTUALIZADAS {
      width: 100%;           /* Ocupa todo el ancho disponible */
      min-height: 50px;     /* Altura mínima */
      height: calc(100vh - 100px); /* Ajusta la altura restando un espacio para la cabecera si es necesario */
      display: flex;
      align-items: stretch; /* Asegura que el contenido se estire */
    }

    #FACTURASACTUALIZADAS iframe {
      width: 100%;  /* Ocupa todo el ancho */
      height: 100%; /* Ocupa toda la altura del div */
      border: none; /* Elimina el borde del iframe */
    }

    /* Asegurar que el body ocupe al menos toda la pantalla */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Contenido principal que empuja el footer hacia abajo */
    main {
      flex: 1;
    }
      /* VISTA PREVIA */
  .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5); /* fondo oscuro semitransparente */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* asegúrate que esté encima de todo */
  }

  .modal-content {
    background: white;
    width: 80%;
    height: 90%;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    overflow: hidden;
    position: relative;
  }
  [v-cloak] {
  display: none;
  }
  /* FIN VISTA PREVIA */
  </style>
<!----------ING ROBERTO ALVAREZ 24/MARZO/2025--------->

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
      <div class="col-md-3 col-sm-3 col-xs-3">
        <h4 class="titulo-secciones">ALTA DE FACTURAS Y PAGOS CON TARJETAS</h4>
        
        <button class="btn btn-primary" onclick="traerFormasPagos('')" style="display: none;">
          Crear Notas
        </button>
        
        <button class="btn btn-primary" onclick="buscarPersonasConNotas('')" style="display: none;" >
          Notas
        </button>
      </div>
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
  <form  class="form-horizontal" role="formreferidos" id="formreferidos" name="formreferidos" method="post" action="<?=base_url()?>presupuestos/GuardarFactura/"  onsubmit="guardarFacturaAlv(this, event)">


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
            <div class="col-sm-3 col-md-3 container-Guardar">
              <div class="col-md-8">
                <button type="submit" class="btn btn-primary " name="button" id="button" align="left" onclick="enviarForm(this, event)" style="border-radius: 5px;">
                  Guardar
                </button><!-- onclick="enviarForm(event)" --> 
                <!-- <button class="btn btn-light btn-Limpiar" id="LimpiarCampos">Limpiar</button> -->
              </div>
            </div>  

          
        </div><br>
        
        <div class="row">
          <!-- Monto del Mes -->
          <div class="col-sm-3 col-md-3">
            <h3>
              <span class="label label-primary">Monto de Mes:</span>
              <span class="label label-warning" id="montoMesLabel"></span>
            </h3>
          </div>

          <!-- Monto Autorizado -->
          <div class="col-sm-3 col-md-3">
            <h3>
              <span class="label label-primary">Monto Autorizado:</span>
              <span class="label label-warning" id="montoMesAutorizadoLabel"></span>
            </h3>
          </div>

          <!-- Monto Disponible -->
          <div class="col-sm-3 col-md-3">
            <h3>
              <span class="label label-primary">Monto Disponible:</span>
              <span class="label label-warning label-lg" id="montoDisponibleLabel"></span>
            </h3>
          </div>
        </div>
      </div>
  <div class="col-md-3 col-sm-3 col-xs-3"> 
        
 </div>
  </form >      
 </section>    
<!-- End navbar -->


<!----------ING ROBERTO ALVAREZ 24/MARZO/2025---------> 
<!-- <div id="FACTURASACTUALIZADAS">
  |<iframe id="facturasFrame" src="<?=base_url()?>presupuestos/obtenerFacturasAjax" frameborder="0"></iframe>
</div> -->
<!----------ING ROBERTO ALVAREZ 24/MARZO/2025--------->
<?php $this->load->view('presupuestos/vistaFactura'); ?>  










<div id="divModalGenerico" class="modalCierra">

  <div id="divModalContenidoGenerico" class="modal-contenido">

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <button onclick="cerrarModal('divModalGenerico')" style="color: white; background-color: red; border: double; position: relative; left: 95%;">X</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <label class="etiquetaSimple">Modo de Pago</label>
        <select id="selectFormasPago" class="form-control" onchange="cambiarFormPago(this)"></select>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <label class="etiquetaSimple">Descripción</label>
        <input type="text" id="notasDescripcio" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 col-sm-3">
        <label class="etiquetaSimple">Cargo Fianzas</label>
        <input type="text" id="notasCargoFianzas" class="form-control">
      </div>
      <div class="col-md-3 col-sm-3">
        <label class="etiquetaSimple">Cargo Seguros</label>
        <input type="text" id="notasCargoSeguros" class="form-control">
      </div>
      <div class="col-md-3 col-sm-3">
        <label class="etiquetaSimple">Cargo Coorporativo</label>
        <input type="text" id="notasCargoCoorporativos" class="form-control">
      </div>
      <div class="col-md-3 col-sm-3">
        <label class="etiquetaSimple">Cargo Especiales</label>
        <input type="text" id="notasCargoEspeciales" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 col-sm-3">
        <label class="etiquetaSimple">Fecha</label>
        <input type="text" id="fechaNota" class="form-control fecha">
      </div>
      <div class="col-md-3 col-sm-3">
        <label class="etiquetaSimple">Subtotal</label>
        <input type="text" id="notasTotal" class="form-control">
      </div>
      <div class="col-md-3 col-sm-3">
        <br>
        <button class="btn btn-success" onclick="guardarNota('')">Guardar Nota</button>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <table class="table">
          <thead>
            <tr>
              <th>Forma de pago</th>
              <th>Número tarjeta</th>
              <th>Descripción</th>
              <th>Fecha Compra</th>
              <th>Fianzas</th>
              <th>Seguros</th>
              <th>Coorporativo</th>
              <th>Especiales</th>
              <th>Monto de Compra</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="tbodyNotas">
            <!-- Aquí se agregan las filas dinámicamente -->
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
  /* Fondo oscuro de modal */
  .modalCierra,
  .modalAbre {
    background-color: rgba(0, 0, 0, 0.7);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0px;
    left: 0;
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
  }

  .modalAbre {
      display: flex !important; /* <- asegura que se mantenga flex */
      align-items: center !important; /* <- centra verticalmente */
      justify-content: center !important; /* <- centra horizontalmente */
  }

  /* Contenedor del modal */
  .modal-contenedor {
    background-color: white;
    width: 90%;
    max-width: 900px;
    max-height: 90vh;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  /* Header con botón de cerrar */
  .modal-header {
    display: flex;
    justify-content: flex-end;
    background-color: #007bff;
    padding: 10px;
  }

  .cerrar-btn {
    background-color: red;
    color: white;
    border: none;
    font-size: 20px;
    font-weight: bold;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
  }

  .cerrar-btn:hover {
    background-color: darkred;
  }

  /* Contenido interno */
  .modal-contenido {
    padding: 20px;
    overflow-y: auto;
    flex-grow: 1;
  }
</style>

<?php //$this->load->view('footers/footer'); ?>


<!-- <div id="modalModifcaFactura" style="display: flex;flex-direction: column;" >
  <div style="background:#007bff;display: flex;margin-left: 2%;flex-direction: row-reverse;margin-right: 2%"><button onclick="abrirCerrarEditarFactura()" style="background-color: red;color: white">X</button></div>
  <div id="modalcontenidoFactura" class="modal-contenido"  >
   <?php $this->load->view('presupuestos/editarFacturaGeneral');?>
  </div> 

</div> -->
<div id="modalModifcaFactura" class="modalCierra">
  <div class="modal-contenedor">
    <div class="modal-header">
      <button onclick="abrirCerrarEditarFactura()" class="cerrar-btn">×</button>
    </div>
    <div id="modalcontenidoFactura" class="modal-contenido">
      <?php $this->load->view('presupuestos/editarFacturaGeneral'); ?>
    </div>
  </div>
</div>
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







<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->
<link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">
<!--<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script><!--Roberto-Alvarez-12-05-->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><!--Roberto-Alvarez-12-05-2025-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!--Roberto-Avarez-12-05-2025-->
<!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>Roberto-Alvarez-15-05-2025 -->
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<!--ING-Roberto-Alvarez-12-05-2025-->
<div id="base_url" data-base-url="<?= base_url(); ?>"></div><!--SE TOMA LA UBICACIÓN DE RAIZ V3 SIRVE PARA LA INSTANCIA DE VUE-->
<!--ROBERTO-ALVAREZ-2025-05-26 -->
<?php
$version = filemtime(FCPATH . 'assets/js/presupuestosJS/tablaFacturas.js');
$respuesta = isset($Respuesta) ? $Respuesta : '';
?>
<script>
  var respuesta = "<?= $respuesta ?>";
  const FINAL_URL = "presupuestos/obtenerFacturasJson";
  const URL_MODIFICA_ARCHIVO = "<?= base_url('presupuestos/modificaArchivo/') ?>"; //  PASAR LA URL AL JS //es la ruta en donde se encuentra la función en el controlador 

  const currentVersion = <?= $version ?>;
  const storedVersion = localStorage.getItem('tablaFacturasJSVersion');
  const View = 'listafacturas';//Con esto identifica a que vista corresponde la tabla que se muestra en pantalla 
  if (storedVersion === null || storedVersion != currentVersion) {
    console.log("✅ JS recargado. Versión nueva: " + currentVersion);
    localStorage.setItem('tablaFacturasJSVersion', currentVersion);
  }
</script>
<script src="<?= base_url('assets/js/presupuestosJS/tablaFacturas.js') ?>?v=<?= $version ?>"></script>

<!--ROBERTO-ALVAREZ-2025-05-26 --> 