<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
?>
<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  
    $( function(){$( "#1fNacimiento" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );

     $(document).ready(function () {
   $('.fecha').datepicker();
 });

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


<?php $this->load->view('presupuestos/vistaFactura'); ?><!--AQUI SE VISUALIZA LA TABLA DE FACTURAS--><!--ROBERTO-ALVAREZ-27-MAYO-2025-->
    <!-- <div class="row">
      <form id="grabarFechaForm" method="GET" action="">
        <input type="hidden" name="IDFact" id="IDFact">
        <input type="hidden" name="IDUser" id="IDUser">

        <div class="col-md-8 col-sm-8">
          <input type="date" name="1fNacimiento" class="form-control">
        </div>

        <div class="col-md-4 col-sm-4">
          <button class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div> -->
<div id="divModalGenerico" class="modalCierra">
  <div id="divModalContenidoGenerico" class="modal-contenido shadow rounded p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="m-0">�� Captura de Fecha</h4>
      <button onclick="abrirModalFecha(this)" class="btn-close" aria-label="Close">x</button>
    </div>

    <hr>

    <div class="mb-3">
      <label class="form-label text-primary fw-bold">ID de Factura:</label>
      <div>
        <span id="usuarioFacturaID" class="badge bg-warning text-dark"></span>
      </div>
    </div>
       <div class="mb-3">
      <label class="form-label text-primary fw-bold">Comprobante pago</label>
      <div>
        <span id="Comprobante_pago" class="badge bg-warning text-dark"></span><!--quiero pasar el nombre del comprobante-->
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label text-primary fw-bold">Usuario:</label>
      <div>
        <span id="usuarioFacturaFolio" class="badge bg-warning text-dark"></span>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label text-primary fw-bold">Folio de Factura:</label>
      <div>
        <span id="usuarioFacturaEmail" class="badge bg-warning text-dark"></span>
      </div>
    </div>

    <form id="grabarFechaForm" method="GET" action="<?= base_url('presupuestos/AplicaPago') ?>">
      <input type="hidden" name="IDFact" id="IDFact">
      <input type="hidden" name="IDUser" id="IDUser">

      <div class="mb-3">
        <label for="fechaNacimiento" class="form-label fw-bold">Selecciona una fecha:</label>
        <input type="date" name="unofNacimiento" id="fechaNacimiento" class="form-control">
      </div>
      <!--para buscar en donde se hace el post solo tienen que buscar en tablaFacturas.js lo siguiente: -->
      <!--  if (typeof View !== 'undefined' && View === 'listafacturaspago')  -->
      <div class="text-end">
        <button type="submit" class="btn btn-success">�� Guardar</button> 
      </div>
    </form>

  </div>
</div>

<style>
  body { overflow: scroll; }

  .modalCierra {
    background-color: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0; right: 0; bottom: 0; left: 0;
    opacity: 0;
    transition: all 0.5s;
    display: none;
    z-index: 1000;
  }

  .modalAbre {
    background-color: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0; right: 0; bottom: 0; left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.5s;
    z-index: 1000;
  }

  .modal-contenido {
    background-color: #fff;
    width: 90%;
    max-width: 500px;
    padding: 20px;
    border-radius: 1rem;
    position: relative;
    z-index: 1001;
  }
</style>




<!-- ROBERTO-ALVAREZ-27-05-2025 -->
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
<script>                                                                                                                                                                               //<!---->
  var respuesta = "<?= $respuesta ?>";                                                                                                                                                //<!---->
  const FINAL_URL = "presupuestos/ListaPagosAutorizarVue";//parte final de la url en donde se obtienen los datos que se muetran en la tabla                                                //<!---->
  const URL_MODIFICA_ARCHIVO = "<?= base_url('presupuestos/modificaArchivo/') ?>"; //  PASAR LA URL AL JS //es la ruta en donde se encuentra la función en el controlador        //<!---->
                                                                                                                                                                                      //<!---->
  const currentVersion = <?= $version ?>;                                                                                                                                             //<!---->
  const storedVersion = localStorage.getItem('tablaFacturasJSVersion');                                                                                                               //<!---->
  const View = 'listafacturaspago';//Con esto identifica a que vista corresponde la tabla que se muestra en pantalla                                                                //<!---->
  if (storedVersion === null || storedVersion != currentVersion) {                                                                                                                    //<!---->
    console.log("✅ JS recargado. Versión nueva: " + currentVersion);                                                                                                                 //<!---->
    localStorage.setItem('tablaFacturasJSVersion', currentVersion);                                                                                                                   //<!---->                                                                                                                
  }                                                                                                                                                                                   //<!---->
</script>                                                                                                                                                                               <!---->
<script src="<?= base_url('assets/js/presupuestosJS/tablaFacturas.js') ?>?v=<?= $version ?>"></script>                                                                             <!---->    
 <!--ROBERTO-ALVAREZ-2025-05-26 -->                                                                                                                                                     <!---->
 <!--------------------------------------------------------------------TODOS-ESTOS-ARCHIVOS-SON-NECESARIOS-PARA-LA-CORRECTA-VISUALIZACIÓN-DE-$this->load->view('presupuestos/vistaFactura');-->

<!-- ROBERTO-ALVAREZ-27-05-2025 -->