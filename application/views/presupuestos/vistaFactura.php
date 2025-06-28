<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
// $totalResultados = $Listafacturas->num_rows();
/*$mostrar_Vista = false; // No mostrar la vista visualmente, pero sí cargarla

    if ($mostrar_Vista) {
        $this->load->view('headers/menu');
        $this->load->view('headers/header');
    } else {
        echo '<div style="display: none;">';
        $this->load->view('headers/menu');
        $this->load->view('headers/header');
        echo '</div>';
    }*/
?>
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
.contenedor-tabla {
  position: relative;
  max-height: 500px; /* ajusta a tu necesidad */
  overflow-y: auto;
  border: 1px solid #ccc;
}

.thead-sticky th {
  position: sticky;
  top: 0;
  background: white;
  z-index: 3;
}

/* Totales al fondo */
.totales-footer {
  position: sticky;
  bottom: 0;
  display: flex;
  justify-content: space-between;
  background: white;
  padding: 10px 20px;
  border-top: 1px solid #ccc;
  z-index: 3;
}

.col-izquierda h4,
.col-derecha h4 {
  margin: 0;
  font-weight: bold;
}

  </style>
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
  <div id="app"><!---------------------------------------------------------------------------------------------INICIO VUE------------------------------------------------------------------------------>
    <!-- NUEVO BLOQUE VISUAL TEMPORAL -->
    <div class="container-fluid" style="padding: 10px; margin-top: 20px;">
      <div class="row g-3">
        
        <!-- SECCIÓN 1: Fechas -->
        <div v-if="botonesSegmentos.mostrarFechasServidor" class="col" style="border-right: 1px solid darkgray;" v-cloak><!--ESTE HACE LA PETICIÓN DESDE EL SERVIDOR-->
        <div class="row">
          <div class="col-md-6">
            <label class="title-input">Fecha Inicial:</label>
            <!-- <input type="date" class="form-control input-sm" id="textFecInicial"> -->
             <input type="date" class="form-control input-sm" v-model="fechaInicial" :max="fechaFinal">
          </div>
          <div class="col-md-6">
            <label class="title-input">Fecha Final:</label>
            <!-- <input type="date" class="form-control input-sm" id="textFecFinal"> -->
             <input type="date" class="form-control input-sm" v-model="fechaFinal" :min="fechaInicial">
          </div>
          <div class="col-md-12" style="margin-top: 10px;">
            <button class="btn btn-primary btn-block w-100" @click=" iniciarBusqueda()">
              <i class="fa fa-search me-2"></i> Consultar
            </button>
          </div>
        </div>
        </div>
        <div v-if="botonesSegmentos.mostrarFechas" class="col" style="border-right: 1px solid darkgray;" v-cloak><!--ESTE BUSCA DENTRO DE VUE-->
          <div class="row">
            <div class="col-md-6">
              <label class="title-input">Fecha Inicial:</label>
              <input type="date" class="form-control input-sm" v-model="fechaInicial" :max="fechaFinal">
            </div>
            <div class="col-md-6">
              <label class="title-input">Fecha Final:</label>
              <input type="date" class="form-control input-sm" v-model="fechaFinal" :min="fechaInicial">
            </div>
            <div class="col-md-12" style="margin-top: 10px;">
              <button class="btn btn-secondary btn-block w-100" @click="limpiarFechas">
                  <i class="fa fa-eraser me-2"></i> CLEAN
              </button>
            </div>
          </div>
        </div>

        <!-- SECCIÓN 2: Filtros -->
        <div v-if="botonesSegmentos.mostrarFiltros" class="col" style="border-right: 1px solid darkgray;" v-cloak>
          <!-- <label class="title-input">Filtrar Tabla Facturas:</label>
          <select id="filtrarUsuario" onchange="filterUser()" class="form-control input-sm">
            <option value="0">Sin Usuarios para filtrar</option>
          </select> -->
          <div class="alert alert-primary d-flex align-items-center mt-2" role="alert" style="font-size:15px; position: relative;">
            <i class="fa fa-search me-2" aria-hidden="true"></i>
            <div style="width: 100%; position: relative;">
              <input type="text" v-model="buscar" class="form-control" placeholder="Buscar..." style="font-size:14px;">
              <!-- Lista de sugerencias -->
              <ul v-if="sugerencias.length > 0" class="list-group position-absolute w-100" style="z-index: 999;">
                <li class="list-group-item list-group-item-action" v-for="(sugerencia, index) in sugerencias" :key="index" @click="seleccionarSugerencia(sugerencia)"
                  style="cursor: pointer;">
                  {{ sugerencia }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- SECCIÓN 3: Botones -->
        <div v-if="botonesSegmentos.mostrarBotones" class="col" v-cloak>
          <div class="alert alert-primary text-center" role="alert" id="AlertaInfo" style="font-size: 15px;">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <span class="st-info">Para eliminar debes seleccionar una factura.</span>
          </div>
          <button type="button" class="btn btn-danger w-100" id="btn-EliminarFactura2" onclick="eliminarFacturaSRP(event, '')">
            <i class="fa fa-trash"></i> ELIMINAR FACTURA
          </button>
          <button class="btn btn-success w-100 mt-2" onclick="exportarConXLSX()">
            <i class="fa fa-file-excel-o"></i> Exportar Excel
          </button>
        </div>


      </div>
    </div>
    <section class="container-fluid breadcrumb-formularios" id="bloqueaActualizar">
      <div class="col-md-12" id="DivRoot" align="left" style="padding: 0px;margin-bottom:20px;">
        <div class="hidden" style="overflow: hidden;" id="DivHeaderRow"></div>
        <!-- <div id="DivMainContent"> -->
          <div class="table-responsive" style="padding: 0px;background: white;border-radius: 5px;overflow: auto;height: 800px;">
            <table class="table" id='Mitabla'>
              <thead style="position: sticky;top: 0px;">
                <tr>
                  <th name="AccionesTabla" v-if="columnasVisibles.editar">Editar Factura</th>
                  <th                                            name="Id"               >Id</th>
                  <th v-if="columnasVisibles.Solicitado_por"     name="Solicitado por"   >Solicitado por</th>
                  <th v-if="columnasVisibles.fecha_factura"      name="Fecha Factura"    >Fecha Factura</th>
                  <th v-if="columnasVisibles.fecha_captura"      name="Fecha Captura"    >Fecha Captura</th>
                  <th v-if="columnasVisibles.folio_factura"      name="Folio"            >Folio</th>
                  <th v-if="columnasVisibles.concepto"           name="Concepto"         >Concepto</th>
                  <th v-if="columnasVisibles.subtotal"           name="Subtotal"         >Subtotal</th>
                  <th v-if="columnasVisibles.totalfactura"       name="Total a pagar"    >Total a pagar</th>
                  <th v-if="columnasVisibles.Accion"             name="Accion"           >Accion</th>
                  <th v-if="columnasVisibles.autorizado"         name="Autorizado"       >Autorizado</th>
                  <th v-if="columnasVisibles.pagado"             name="Pagado"           >Pagado</th>
                  <th v-if="columnasVisibles.fecha_pago"         name="Fecha Pago"       >Fecha Pago</th>
                  <th v-if="columnasVisibles.validar"            name="Validar"          >Validar</th>
                  <th v-if="columnasVisibles.Usuario"            name="Usuario"          >Usuario</th><!--nombreUsuario--><!--Solicitado por-->
                  <th v-if="columnasVisibles.cuentaContable"     name="Cuenta contable"  >Cuenta contable</th>
                  <th v-if="columnasVisibles.personaDepartamento"name="Departamento"     >Departamento</th>
                  <th v-if="columnasVisibles.nombreProveedor"    name="Proveedor"        >Proveedor</th>
                  <th v-if="columnasVisibles.Agregar_PDF"        name="Agregar PDF"      >Agregar PDF</th><!--botones-->
                  <th v-if="columnasVisibles.Agregar_XML"        name="Agregar XML"      >Agregar XML</th><!--botones-->
                  <th v-if="columnasVisibles.Comprobante_pago"   name="Comprobante pago" >Comprobante Archivospago</th>
                  <th                                            name="Archivos"         >Archivos</th>
                  <th v-if="columnasVisibles.tarjeta"            name="Tarjeta Asignada" >Tarjeta Asignada</th>
                  <th v-if="columnasVisibles.tipo_factura"       name="Tipo Compra"      >Tipo Compra</th>
                  <th v-if="columnasVisibles.Correo_Usuario"     name="Correo Usuario"   >Correo Usuario</th>
                </tr>
              </thead>

              <tbody id="bodyTabla">
                <!-- <tr
                  v-for="(row, index) in filtroFactura"
                  :key="row.id"
                  name="FilaSelect"
                  :class="{ rowSeleccionado: rowSeleccionado === row.id }"
                  onclick="escogerRow(this)"
                  :data-idfactura="row.id"
                > -->
                <tr
                  v-for="(row, index) in filtroFactura"
                  :key="row.id"
                  name="FilaSelect"
                  :class="{ rowSeleccionado: rowSeleccionado === row.id }"
                  onclick="escogerRow(this)"
                  :data-id="row.id"
                  :data-usuario="row.Usuario"
                  :data-folio="row.folio_factura"
                  :data-comprobante-pago="row.Comprobante_pago"
                >

                  <!-- Acciones -->
                  <td name="AccionesTabla" v-if="columnasVisibles.editar">
                    <div v-if="row.validada == 0 || row.validada == '0'" class="container-segment">
                      <button class="btn btn-primary" :onclick="'datosDeFacturaEFG(\'\', ' + row.id + ');abrirCerrarEditarFactura(true)'">
                        Editar
                      </button>
                    </div>
                  </td>

                  <!-- Datos básicos -->
                  <td name="Id"                >{{ row.id }}                                </td>
                  <td name="Solicitado por"    v-if="columnasVisibles.Solicitado_por"      >{{ row.nombreUsuario }}         </td>
                  <td name="Fecha Factura"     v-if="columnasVisibles.fecha_factura"       >{{ row.fecha_factura }}         </td>
                  <td name="Fecha Captura"     v-if="columnasVisibles.fecha_captura"       >{{row.fecha_captura}}           </td>
                  <td name="Folio"             v-if="columnasVisibles.folio_factura"       >{{ row.folio_factura }}         </td> 
                  <td name="Concepto"          v-if="columnasVisibles.concepto"            >{{ row.concepto }}              </td>
                  <td name="Subtotal"          v-if="columnasVisibles.subtotal"            >{{ row.totalfactura }}          </td>
                  <td name="Total a pagar"     v-if="columnasVisibles.totalfactura"        >{{ row.totalconiva }}           </td>
                  <!-- Botón de acción según posteriorapago -->
                  <td v-if="columnasVisibles.Accion">
                    <button
                      v-if="row.posteriorapago !== '6'"
                      :data-href="`${baseURL}presupuestos/AplicaPago?`"
                      class="btn btn-primary btn-xs contact-item"
                      onclick="abrirModalFecha(this)"
                    >
                    <!-- IDCL=${row.id} -->
                      <span class="glyphicon glyphicon-pencil"></span> Pagar
                    </button>

                    <button
                      v-else
                      :data-href="`${baseURL}presupuestos/PagarReembolso?`"
                      class="btn btn-primary btn-xs contact-item"
                      onclick="abrirModalFecha(this)"
                    >
                      <span class="glyphicon glyphicon-pencil"></span> Rembolsar
                    </button>
                  </td>


                  <!-- Estatus -->
                  <td name="Autorizado"        v-if="columnasVisibles.autorizado"          >{{ row.estatus_autorizacion }}  </td>
                  <td name="Pagado"            v-if="columnasVisibles.pagado"              >{{ row.estatus_pago }}          </td>
                  <td name="Fecha Pago"        v-if="columnasVisibles.fecha_pago"          >{{ row.fecha_pago }}            </td>
 
                  <!-- Validar -->
                  <td name="Validar"           v-if="columnasVisibles.validar">
                    <button class="btn btn-primary btn-xs contact-item" @click="validarFactura(row.id)">
                      <span class="glyphicon glyphicon-pencil"></span>
                      Validar
                    </button>
                  </td>
                  <!-- Validar -->


                  <!-- Usuario y organización -->
                  <td name="Usuario"           v-if="columnasVisibles.Usuario"             >{{ row.nombreUsuario }}         </td>
                  <td name="Cuenta contable"   v-if="columnasVisibles.cuentaContable"      >{{ row.cuentaContable }}        </td>
                  <td name="Departamento"      v-if="columnasVisibles.personaDepartamento" >{{ row.personaDepartamento }}   </td>
                  <td name="Proveedor"         v-if="columnasVisibles.nombreProveedor"     >{{ row.nombreProveedor }}       </td>

                  <!-- PDF -->
                  <td name="Agregar PDF"       v-if="columnasVisibles.Agregar_PDF"  :id="'filePDF' + row.id"                    >
                    <div v-if="archivoValido(row.archivoNombrePDF)" class="col-md-12 container-downloadFile">
                      <select class="form-control input-sm dropdownFile" :ref="'selectPDF' + row.id">
                        <option :value="ruta + 'ArchivosPresupuesto/' + row.id + '/' + row.archivoNombrePDF">Descargar</option>
                        <option :value="row.archivoNombrePDF">Eliminar</option>
                      </select>
                      <button type="button" class="btn-OK" style="padding-top: 3px; margin-top: 25px;" @click="opcionesArchivo(row.id, 'pdf', row.nombreUsuario)">
                        OK
                      </button>
                    </div>
                    <div v-else class="divContenedor">
                      <form @submit.prevent="subirArchivoPDF(row.id, $event)" enctype="multipart/form-data">
                        <input type="hidden" :value="row.id" name="id" />
                        <input type="file" name="Archivo" class="Archivo1" @change="subirArchivo(row.id, $event, 'pdf')" />
                        <label class="subir-pdf">Agregar PDF</label>
                      </form>
                    </div>
                  </td>

                  <!-- XML -->
                  <td name="Agregar XML"       v-if="columnasVisibles.Agregar_XML"   :id="'fileXML' + row.id"                    >
                    <div v-if="archivoValido(row.archivoNombreXML)" class="col-md-12 container-downloadFile">
                      <select class="form-control input-sm dropdownFile" :ref="'selectXML' + row.id">
                        <option :value="ruta + 'ArchivosPresupuesto/' + row.id + '/' + row.archivoNombreXML">Descargar</option>
                        <option :value="row.archivoNombreXML">Eliminar</option>
                      </select>
                      <button type="button" class="btn-OK" style="padding-top: 3px; margin-top: 25px;" @click="opcionesArchivo(row.id, 'xml')">
                        OK
                      </button>
                    </div>
                    <div v-else class="divContenedor">
                      <form :action="ruta + 'presupuestos/GuardarArchivoALV'" :id="'GuardarArchivo' + row.id"
                            enctype="multipart/form-data" method="post" style="height: 80px;">
                        <input type="hidden" :value="row.id" name="id" />
                        <input type="hidden" value="xml" name="tipo" />
                        <input type="file" name="Archivo" class="Archivo1" @change="subirArchivo(row.id, $event, 'xml')" />
                        <label class="subir-xml" for="file">Agregar XML</label>
                      </form>
                    </div>
                  </td> 
                  <!-- Comprobante de Pago -->
                  <td v-if="columnasVisibles.Comprobante_pago">
                  <div v-if="archivoValido(row.Comprobante_pago)" class="col-md-12 container-downloadFile">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        style="margin-left: 10px;"
                        @click="eliminarComprobantePago(row.id)"
                      >
                        Eliminar
                      </button>
                    </div>

                    <div v-else class="divContenedor">
                      <form @submit.prevent="subirComprobantePago(row.id, $event)" enctype="multipart/form-data">
                        <input type="file" name="Archivo" class="Archivo1" @change="subirComprobantePago(row.id, $event)" />
                        <label class="subir-pdf">Agregar Comprobante</label>
                      </form>
                    </div>
                  </td>


                  <!-- Ver archivos -->
                  <td name="Archivos"                                                          >
                    <button type="button" class="btn-OK" data-type="presupuestos" style="padding-top: 3px; margin-top: 25px;"
                            @click="verArchivos(row.id)">
                      Vista Archivos
                    </button>
                  </td>

                  <!-- Tarjeta y tipo -->
                  <td name="Tarjeta Asignada"  v-if="columnasVisibles.tarjeta"               >{{ row.numeroTarjeta }}
                                                                                              {{ row.formaPago }}</td>
                  <td name="Tipo Compra"       v-if="columnasVisibles.tipo_factura"          >{{ row.tipo_factura }}                    </td>
                  <td name="Correo Usuario"    v-if="columnasVisibles.Correo_Usuario"        >{{row.Usuario}} </td>
                </tr>
              </tbody>
                <!-- Totales fijos abajo -->               
              <tfoot v-if="filtroFactura.length === 0"  style="position: sticky;bottom: 0px;">
                <tr>
                  <td colspan="4" style="text-align: center;">
                    <b>No se encontraron registros.</b>
                  </td>
                </tr>
              </tfoot>
                <!--Suma de las columnas SubTotal y Total -->
              <tfoot v-if="columnasVisibles.totalSuma" style="position: sticky; bottom: 0px; background: #3E1F7A; color: white;">
                <tr>
                  <td colspan="7" style="text-align: right;">
                    <b>{{ numberFormat.format(totalSinIVA) }}</b>
                  </td>
                  <td colspan="12" style="text-align: left;">
                    <b>{{ numberFormat.format(totalConIVA) }}</b>
                  </td>
                </tr>
              </tfoot>



            </table>
          </div>
          <div id="DivFooterRow" style="overflow:hidden">
        <div class="row">
          <div class="col-md-12" style="font-size: 15px;">
            <small><i>Total de resultados: <b>{{ filtroFactura.length }}</b></i></small>
          </div>
        </div>
      </div> 
    </section><!-----------------------------------------------------------------------------------FIN TABLA FACTURAS GENERADAS-------------------------------------------------------------------->
    <!----------------------------------------------------------------------------INICIO VISTA PREVIA---------------------------------------------------->
    <div v-if="vistaPrevia" class="modal-overlay" v-cloak>
      <div class="modal-content" style="position: relative; width: 90vw; height: 90vh; display: flex; flex-direction: column;">
        <button @click="cerrarVistaPrevia" style="position: absolute; top: 10px; right: 10px; z-index: 10000;">✖</button>

        <!-- Cabecera: lista de archivos -->
        
        <div style="padding: 20px; text-align: left; max-height: 30vh; overflow-y: auto;">
          <div>
            <span style="font-size: 24px;">
              �� Carpeta
              <!-- Icono de descarga de carpeta (no descarga realmente la carpeta, solo un botón ilustrativo) -->
            <a :href="ruta + apiDescargarZip + '/' + idActual" style="margin-left: 10px; font-size: 18px;" title="Descargar todos los archivos en ZIP">
              ⏬
            </a>

            </span>

            <ul v-if="archivosEnCarpeta.length > 0" style="list-style: none; padding-left: 20px;">
              <li v-for="(archivo, index) in archivosEnCarpeta" :key="index" style="margin-bottom: 6px;">
                <span style="cursor: pointer; color: blue;" @click="mostrarArchivo(apiRutaBase + '/' + archivo)">
                  �� {{ archivo }}
                </span>
                <!-- Icono de descarga -->
                <a :href="apiRutaBase + '/' + archivo"
                  :download="archivo"
                  title="Descargar archivo"
                  style="margin-left: 10px; text-decoration: none; font-size: 18px;">
                  ⏬
                </a>
              </li>
            </ul>

            <p v-else style="margin-top: 10px;">(La carpeta está vacía)</p>
          </div>
        </div>


          <!-- Cuerpo: Vista previa del archivo -->
        <div style="flex-grow: 1; overflow: auto; display: flex; align-items: center; justify-content: center; background: #f9f9f9;">
          <div v-if="archivoNoEncontrado" style="padding: 20px; text-align: center;">
            <h2 style="color: red;">ARCHIVO NO ENCONTRADO</h2>
          </div>

          <pre v-else-if="esXml" style="overflow: auto; max-height: 100%; background-color: #f4f4f4; padding: 10px; width: 100%;">
            {{ contenidoXml }}
          </pre>

          <iframe v-else-if="urlDelPdf" :src="urlDelPdf" width="100%" height="100%" style="border: none;"></iframe>

          <div v-else style="text-align: center; color: #666;">
            <p style="font-size: 18px;">Selecciona un archivo para vista previa</p>
            <p style="font-size: 48px;">��</p>
          </div>
        </div>


      </div>
    </div>
      <!-- FIN VISTA PREVIA -->
  </div><!--FIN VUE-->
