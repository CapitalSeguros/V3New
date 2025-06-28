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
<style>
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
<?php $this->load->view('presupuestos/vistaFactura'); ?><!--TABLA DE LAS FACTURAS-->
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

<!-- ROBERTO-ALVAREZ-27-05-2025 TODOS-ESTOS-ARCHIVOS-SON-NECESARIOS-PARA-LA-CORRECTA-VISUALIZACIÓN-DE-$this->load->view('presupuestos/vistaFactura');-->
 <!--------------------------------------------------------------------TODOS-ESTOS-ARCHIVOS-SON-NECESARIOS-PARA-LA-CORRECTA-VISUALIZACIÓN-DE-$this->load->view('presupuestos/vistaFactura');-->
<link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
<!--<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script><!--Roberto-Alvarez-12-05-->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script><!--Roberto-Alvarez-12-05-2025-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!--Roberto-Avarez-12-05-2025-->
<!-- <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>Roberto-Alvarez-15-05-2025 -->
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<!--ING-Roberto-Alvarez-12-05-2025-->
<div id="base_url" data-base-url="<?= base_url(); ?>"></div><!--SE TOMA LA UBICACIÓN DE RAIZ V3 SIRVE PARA LA INSTANCIA DE VUE-->
<!--ROBERTO-ALVAREZ-2025-05-26 -->                                                                                                                                                     <!---->
<?php
$version = filemtime(FCPATH . 'assets/js/presupuestosJS/tablaFacturas.js');                                                                                                 //<!---->
$respuesta = isset($Respuesta) ? $Respuesta : '';                                                                                                                                     //<!---->
?>                                                                                                                                                                                      <!---->
<script>
  // Variables necesarias para el JS externo:
  var respuesta = "<?= $respuesta ?>";
  var ruta = '';
  // var FINAL_URL = "presupuestos/VistafacturasTodasVue/2025-05-01/2025-06-02"; // o déjalo vacío si vas a usar `iniciarBusqueda()`
  var FINAL_URL = "";
  var baseUrlElement = document.getElementById("base_url");
  if (baseUrlElement) {
    ruta = baseUrlElement.getAttribute('data-base-url');
  } else {
    console.error('El div "base_url" no se encuentra en el DOM.');
  }

  const URL_MODIFICA_ARCHIVO = "<?= base_url('presupuestos/modificaArchivo/') ?>";
  const currentVersion = <?= $version ?>;
  const storedVersion = localStorage.getItem('tablaFacturasJSVersion');
  const View = 'listafacturasTodas';
  if (storedVersion === null || storedVersion != currentVersion) {
    console.log("✅ JS recargado. Versión nueva: " + currentVersion);
    localStorage.setItem('tablaFacturasJSVersion', currentVersion);
  }
</script>
<!-- ✅ El archivo JS que usa FINAL_URL ya se carga después -->
  <script src="<?= base_url('assets/js/presupuestosJS/tablaFacturas.js') ?>?v=<?= $version ?>"></script>                                                                          <!---->    
 <!--ROBERTO-ALVAREZ-2025-05-26 -->                                                                                                                                                     <!---->
 <!--------------------------------------------------------------------TODOS-ESTOS-ARCHIVOS-SON-NECESARIOS-PARA-LA-CORRECTA-VISUALIZACIÓN-DE-$this->load->view('presupuestos/vistaFactura');-->

<!-- ROBERTO-ALVAREZ-27-05-2025 -->










<!-- <script>
function abrirCerrarEditarFactura(abrir = false) {
  const modal = document.getElementById("modalModifcaFactura");
  if (abrir) {
    modal.classList.remove("modalCierra");
    modal.classList.add("modalAbre");
  } else {
    modal.classList.add("modalCierra");
    modal.classList.remove("modalAbre");
    // window.vm.obtenerFacturas?.();
  }
}

abrirCerrarEditarFactura();

guardarEFG_BTN.addEventListener('click', function () {
  actualizarDatosFacturaEFG('actualizarTablaFactura');
});

function actualizarTablaFactura(datos) {
  if (datos.success == 1) {
    Swal.fire("¡Modificado!", "Se modificó correctamente", "success");
    console.log(datos);
    setTimeout(() => {
      window.vm.obtenerFacturas?.();
    }, 2000);
    
  }
}
</script> -->