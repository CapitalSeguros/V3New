<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
?>
<?php $this->load->view('headers/header'); ?>

<?php $this->load->view('headers/menu');?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  
    $( function(){$( "#1fNacimiento" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );
</script>


<meta name="viewport" content="width=900px"/>

<?php $this->load->view('presupuestos/vistaFactura'); ?><!--AQUI SE VISUALIZA LA TABLA DE FACTURAS--><!--ROBERTO-ALVAREZ-27-MAYO-2025-->
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
<!--
<style type="text/css"> body{overflow: scroll;}
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;transition: all 1s;width:100%;height:100%;z-index: 10000}
.modal-contenido{background-color:white;width:40%;height:70%;padding: 0% 0%;margin: 0% auto;position: relative;top: 20%;bottom: -20% }
</style> -->



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
<script>                                                                                                                                                                              //<!---->
  var respuesta = "<?= $respuesta ?>";                                                                                                                                                //<!---->
  const FINAL_URL = "presupuestos/ValidaFacturaJson";//parte final de la url en donde se obtienen los datos que se muetran en la tabla                                                //<!---->
  const URL_MODIFICA_ARCHIVO = "<?= base_url('presupuestos/modificaArchivo/') ?>"; //  PASAR LA URL AL JS //es la ruta en donde se encuentra la función en el controlador        //<!---->
                                                                                                                                                                                      //<!---->
  const currentVersion = <?= $version ?>;                                                                                                                                             //<!---->
  const storedVersion = localStorage.getItem('tablaFacturasJSVersion');                                                                                                               //<!---->
  const View = 'listafacturasvalida';//Con esto identifica a que vista corresponde la tabla que se muestra en pantalla                                                                //<!---->
  if (storedVersion === null || storedVersion != currentVersion) {                                                                                                                    //<!---->
    console.log("✅ JS recargado. Versión nueva: " + currentVersion);                                                                                                                 //<!---->
    localStorage.setItem('tablaFacturasJSVersion', currentVersion);                                                                                                                   //<!---->                                                                                                                
  }                                                                                                                                                                                   //<!---->
</script>                                                                                                                                                                               <!---->
<script src="<?= base_url('assets/js/presupuestosJS/tablaFacturas.js') ?>?v=<?= $version ?>"></script>                                                                             <!---->    
 <!--ROBERTO-ALVAREZ-2025-05-26 -->                                                                                                                                                     <!---->
 <!--------------------------------------------------------------------TODOS-ESTOS-ARCHIVOS-SON-NECESARIOS-PARA-LA-CORRECTA-VISUALIZACIÓN-DE-$this->load->view('presupuestos/vistaFactura');-->

<!-- ROBERTO-ALVAREZ-27-05-2025 -->
