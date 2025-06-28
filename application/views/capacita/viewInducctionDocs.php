<?php 
  	$this->load->view('capacita/menu_capacita'); 
?>
<style type="text/css">
    #doc-canvas {
        border: 1px solid darkgray;
        box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.10);
    }
    .column-flex-center {
        display: flex;
        align-items: center;
    }
</style>
<div class="new-lateral-menu" style="width: 120px; vertical-align: top; display: inline-block; padding: 10px 5px 10px 5px"></div>
<div style="width: 90%; vertical-align: top; display: inline-block">
    <div class="col-md-12">
        <h2 class="mt-4 title-capacita">Documentos de inducción</h2>
        <hr>
        <div class="row column-flex-center">
            <div class="col-md-3"><h5 style="font-size: 13px;margin: 0px;">Seleccione un documento para mostrar</h5></div>
            <div class="col-md-6">
                <select name="document" id="document" class="form-control">
                    <option value="Ninguno">Seleccione</option>
                    <?=array_reduce($docAndExtension, function($acc, $curr){ 
                        if($curr["extension"] == "pdf"){
                            $acc .= "<option value='".$curr["name"].".".$curr["extension"]."'>".$curr["name"]."</option>";
                        }
                        return $acc;
                    }, "")?>
                </select>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <h4>Visor de documentación:</h4>
            <div class="row">
                <div class="col-md-2 b-before btn btn-primary" role="button">Antes</div>
                <div class="col-md-2 b-after btn btn-primary ml-3" role="button">Después</div>
                <div class="col-md-4 mt-2"><h5>Número de página: <span class="number-page">0</span> de <span class="total-pages">0</span></h5></div>
            </div>
            <br>
            <canvas id="doc-canvas"></canvas>
        </div>
    </div>
</div>

<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<!--<script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"></script>-->
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-storage.js"></script>
<script src="<?=base_url()."assets/js/js_inducctionDocsViewer.js"?>"></script>
<script src="<?=base_url()."assets/js/js_manajeNewAgent.js"?>"></script>

<?php $this->load->view('footers/footer'); ?>