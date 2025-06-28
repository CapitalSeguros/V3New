<script src="<?php echo(base_url())?>assets/js/bGenericV1.js"></script>

<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
$sumapre = $presuma;

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
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<style>
    /* Contenedor que hace scroll horizontal en pantallas pequeñas */
.table-responsive {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 1rem;
  align: center;
}

/* Tabla con ancho mínimo para que las columnas no se colapsen */
.table-responsive table {
  min-width: 800px;
  width: 100%;
  border-collapse: collapse;
}

/* Estilos opcionales de tabla para mejor visualización */
.table-responsive th,
.table-responsive td {
  padding: 8px 12px;
  text-align: left;
  border: 1px solid #ddd;
  white-space: nowrap; /* evita que los textos se rompan */
}

/* Encabezado fijo si tu tabla tiene encabezado sticky */
.table-responsive thead th {
  position: sticky;
  top: 0;
  background-color: #f8f8f8;
  z-index: 2;
}

/* Pie de tabla fijo (si se usa) */
.table-responsive tfoot {
  position: sticky;
  bottom: 0;
  background-color: #f0f0f0;
  z-index: 1;
}

</style>
<meta name="viewport" content="width=900px"/>
<div id="app">
    <section class="container-fluid breadcrumb-formularios">
        <div  class="col-md-3 col-sm-3 col-xs-3">
            <h4 class="titulo-secciones">Autoriza Pagos</h4>
        </div>
    </section>
    <section class="container-fluid breadcrumb-formularios" id="bloqueaActualizar">
    <div class="col-md-12" id="DivRoot" align="left" style="padding: 0px;margin-bottom:20px;">
        <div class="hidden" style="overflow: hidden;" id="DivHeaderRow"></div>
           <div
            class="table-responsive draggable-scroll"
            style="max-width: 100%; overflow: auto; cursor: grab;"
            @mousedown="startDrag"
            @mousemove="onDrag"
            @mouseup="stopDrag"
            @mouseleave="stopDrag"
            >
            <table id="Mitabla">
                <thead style="position: sticky; top: 0px; background: white; z-index: 1;">
                <tr>
                    <th>Id</th>
                    <th>Solicitado por</th>
                    <th>Fecha Factura</th>
                    <th>Fecha Captura</th>
                    <th>Folio</th>
                    <th>Concepto</th>
                    <th>Importe</th>
                    <th>Acumulado Mes</th>
                    <th>Límite Mes</th>
                    <th>Acumulado Anual</th>
                    <th>Límite Anual</th>
                    <th>Autorizado</th>
                    <th>Proveedor</th>
                </tr>
                </thead>
                <tbody id="bodyTabla">
                <template v-for="[grupo, contenido] in gruposFacturas" :key="grupo">

                    <!-- FACTURAS CON SUBGRUPOS -->
                    <template v-if="grupo === 'FACTURAS'">
                    <tr :style="{ background: '#145214', color: 'white', cursor: 'pointer' }" @click="toggleGrupo(grupo)">
                        <td colspan="13">
                        <b>{{ grupo }}</b>
                        <span v-if="collapsed[grupo]">
                            <img src="https://cdn-icons-png.flaticon.com/128/12075/12075826.png" width="24">
                        </span>
                        <span v-else>
                            <img src="https://cdn-icons-png.flaticon.com/128/7795/7795785.png" width="24">
                        </span>
                        </td>
                    </tr>

                    <template v-if="!collapsed[grupo]">
                        <template v-for="[subgrupo, facturas] in contenido" :key="subgrupo">
                        <tr :style="{ background: '#4CAF50', color: 'white', cursor: 'pointer' }" @click="toggleGrupo(subgrupo)">
                            <td colspan="13" style="padding-left: 20px;">
                            <b>{{ subgrupo.replace('facturas_', '').toUpperCase() }}</b>
                            <span v-if="collapsed[subgrupo]">
                                <img src="https://cdn-icons-png.flaticon.com/128/12075/12075826.png" width="24">
                            </span>
                            <span v-else>
                                <img src="https://cdn-icons-png.flaticon.com/128/7795/7795785.png" width="24">
                            </span>
                            </td>
                        </tr>

                        <!-- Facturas del subgrupo -->
                        <tr v-for="factura in facturas" :key="factura.id" v-show="!collapsed[subgrupo]" style="background: #E8F5E9;">
                            <td>{{ factura.id }}</td>
                            <td>{{ factura.nombreUsuario }}</td>
                            <td>{{ factura.fecha_factura ?? '—' }}</td>
                            <td>{{ factura.fecha_captura }}</td>
                            <td>{{ factura.folio_factura ?? '—' }}</td>
                            <td>{{ factura.concepto }}</td>
                            <td>{{ factura.totalconiva }}</td>
                            <td>{{ factura.acumuladoMensual }}</td>
                            <td>{{ factura.montoMensual }}</td>
                            <td>{{ factura.presupuestoAutorizadoAnual }}</td>
                            <td>{{ factura.presupuestoAutorizado }}</td>
                            <td>
                            <button
                                @click="autorizar(factura.id)"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded shadow-md transition duration-200"
                            >
                                Autorizar
                            </button>
                            </td>

                            <td>{{ factura.nombreProveedor }}</td>
                        </tr>
                        <!-- Total del subgrupo -->
                        <tr style="background: #E0F2F1; font-weight: bold;" v-if="facturas.length">
                            <td colspan="6" style="text-align: right;">Total Importe</td>
                            <td colspan="7">{{ totalImporte(facturas) }}</td>
                        </tr>
                        </template>
                    </template>
                    </template>

                    <!-- OTROS GRUPOS COMO CAJA CHICA -->
                    <template v-else>
                    <tr :style="{ background: '#2E7D32', color: 'white', cursor: 'pointer' }" @click="toggleGrupo(grupo)">
                        <td colspan="13">
                        <b>{{ grupo }}</b>
                        <span v-if="collapsed[grupo]">
                            <img src="https://cdn-icons-png.flaticon.com/128/12075/12075826.png" width="24">
                        </span>
                        <span v-else>
                            <img src="https://cdn-icons-png.flaticon.com/128/7795/7795785.png" width="24">
                        </span>
                        </td>
                    </tr>
                    <tr v-for="factura in contenido" :key="factura.id" v-show="!collapsed[grupo]" style="background: #C8E6C9;">
                        <td>{{ factura.id }}</td>
                        <td>{{ factura.nombreUsuario }}</td>
                        <td>{{ factura.fecha_factura ?? '—' }}</td>
                        <td>{{ factura.fecha_captura }}</td>
                        <td>{{ factura.folio_factura ?? '—' }}</td>
                        <td>{{ factura.concepto }}</td>
                        <td>{{ factura.totalconiva }}</td>
                        <td>{{ factura.acumuladoMensual }}</td>
                        <td>{{ factura.montoMensual }}</td>
                        <td>{{ factura.presupuestoAutorizadoAnual }}</td>
                        <td>{{ factura.presupuestoAutorizado }}</td>
                        <td>
                        <button
                            @click="autorizar(factura.id)"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded shadow-md transition duration-200"
                        >
                            Autorizar
                        </button>
                        </td>

                        <td>{{ factura.nombreProveedor }}</td>
                    </tr>

                    <!-- Total del grupo -->
                    <tr style="background: #DCEDC8; font-weight: bold;" v-if="contenido.length">
                        <td colspan="6" style="text-align: right;">Total Importe</td>
                        <td colspan="7">{{ totalImporte(contenido) }}</td>
                    </tr>
                    </template>
                </template>
                </tbody>

                <tfoot style="position: sticky; bottom: 0; background: #3E1F7A; color: white;">
                <tr>
                    <td colspan="6" style="text-align: right;"><b>Total General</b></td>
                    <td colspan="7"><b>{{ totalGeneral }}</b></td>
                </tr>
                </tfoot>
            </table>
            </div>
        <div id="DivFooterRow" style="overflow:hidden">
        <div class="row">
            <div class="col-md-12" style="font-size: 15px;">
            <small><i>Total de resultados: <b>{{ totalFacturas }}</b></i></small>
            </div>
        </div>
        </div>
    </div>
    </section>
</div>

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
$version = filemtime(FCPATH . 'assets/js/presupuestosJS/autorizapago.js');                                                                                                 //<!---->
$respuesta = isset($Respuesta) ? $Respuesta : '';                                                                                                                                     //<!---->
?>                                                                                                                                                                                      <!---->
<script>                                                                                                                                                                               //<!---->
  var respuesta = "<?= $respuesta ?>";                                                                                                                                                //<!---->
  const FINAL_URL = "presupuestos/AutorizaFacturaVue";//parte final de la url en donde se obtienen los datos que se muetran en la tabla                                                //<!---->
  const URL_MODIFICA_ARCHIVO = "<?= base_url('presupuestos/modificaArchivo/') ?>"; //  PASAR LA URL AL JS //es la ruta en donde se encuentra la función en el controlador        //<!---->
                                                                                                                                                                                      //<!---->
  const currentVersion = <?= $version ?>;                                                                                                                                             //<!---->
  const storedVersion = localStorage.getItem('tablaFacturasJSVersion');                                                                                                               //<!---->
  const View = 'listafacturasautoriza';//Con esto identifica a que vista corresponde la tabla que se muestra en pantalla                                                                //<!---->
  if (storedVersion === null || storedVersion != currentVersion) {                                                                                                                    //<!---->
    console.log("✅ JS recargado. Versión nueva: " + currentVersion);                                                                                                                 //<!---->
    localStorage.setItem('tablaFacturasJSVersion', currentVersion);                                                                                                                   //<!---->                                                                                                                
  }                                                                                                                                                                                   //<!---->
</script>                                                                                                                                                                               <!---->
<script src="<?= base_url('assets/js/presupuestosJS/autorizapago.js') ?>?v=<?= $version ?>"></script>                                                                             <!---->    
 <!--ROBERTO-ALVAREZ-2025-05-26 -->                                                                                                                                                     <!---->
 <!--------------------------------------------------------------------TODOS-ESTOS-ARCHIVOS-SON-NECESARIOS-PARA-LA-CORRECTA-VISUALIZACIÓN-DE-$this->load->view('presupuestos/vistaFactura');-->

<!-- ROBERTO-ALVAREZ-27-05-2025 -->

<?php //$this->load->view('footers/footer'); ?>
