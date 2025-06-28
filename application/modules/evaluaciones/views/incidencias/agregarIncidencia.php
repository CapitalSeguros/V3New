<?php
echo ('<script src="' . base_url() . 'assets/js/fileupload/public/bundle-fileupload.js" type="text/javascript"></script>');
?>
<?php
$this->load->view('headers/header');
?>
<!-- Navbar -->
<?php
$this->load->view('headers/menu');
?>
<style>
    .titulos {
        font-weight: 900 !important;
    }
    .color{
        background-color:#361866 !important;
    }
</style>
<section class="main-page main-page-close">
    <section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <div class="col-md-6 col-sm-5 col-xs-5">
                    <h3 class="titulo-secciones">Registro de incidencias</h3>
                </div>
            </div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="<?=base_url()?>/">Inicio</a></li>
                    <li><a href="<?=base_url()?>incidencias">Incidencias</a></li>
                    <li class="active">Agregar incidencias</a></li>
                    <?php if ($TipoUser!= 1): ?>
                    <li><a href="<?=base_url()?>incidencias/tipoIncidencia">Tipos de incidencias</a></li>
                    <?php endif; ?>  
                </ol>
		    </div>
        </div>
        <hr />
    </section>
</section>
<section class="container-fluid">
    <!-- aqui va el contenido del formulario -->
    <ul class="color nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Agregar información</a></li>
    <li><a data-toggle="tab" href="#menu1">Subir incidencia</a></li>
  </ul>
  <form action="<?= base_url() ?>incidencias/postAgregarIncidencia" method="POST" class="form" enctype="multipart/form-data">
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="Tipo">Seleccione un tipo de incidencia:</label>
                            <select name="Tipo" id="Tipo" class="form-control input-sm is-invalid">
                                <option selected disabled>Seleccione una opción</option>
                                <? foreach ($tipos as $item) {
                                    echo "<option value=" . $item['id'] . ">" . $item['nombre'] . "</option>";
                                } ?>
                            </select>
                            <?= form_error('Tipo') ?>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="fechaStart">Fecha de inicio:</label>
                            <input type="text" name="fechaStart" id="fechaStart" value="<?= set_value('fechaStart') ?>" class="form-control input-sm fecha fechaStart" placeholder="<?= ($this->input->post('fechaStart', TRUE) != "") ? $this->input->post('fechaStart', TRUE) : date('Y-m-d') ?>" title="Fecha de Inicio" autocomplete="off" value="<?= ($this->input->post('fechaStart', TRUE) != "") ? $this->input->post('fechaStart', TRUE) : date('Y-m-d') ?>">
                            <?= form_error('fechaStart') ?>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="dias">Días:</label>
                            <input type="number" name="dias" id="dias" value="<?= set_value('dias') ?>" class="form-control input-sm"  title="dias" autocomplete="off" >
                            <?= form_error('dias') ?>
                        </div>
                    </div>
                </div><!-- /row -->
                <div class="row">
                    <div class="col-sm-4 col-md-6">
                        <div class="form-group">
                            <label for="Estatus">Escriba un comentario referente:</label>
                            <textarea style="height: 150px" id="smsText" name="smsText" class="form-control input-sm" placeholder="Escriba Aqui" value="<?= set_value('smsText') ?>"><?= $this->input->post('smsText', true) ?></textarea>
                            <p id="contSmsText">Caracteres usados: 0 de 300</p>
                            <?= form_error('smsText') ?>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-6">
                            <div class="form-group">
                                    <div id="jfileupload">
                                    </div>
                            </div>  
                    </div>
                    
                </div>

        </div>
    </div>
    <div id="menu1" class="tab-pane fade">
        <div class="container-fluid">
            <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <br />
                            <button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="Consultar Reporte">Registrar Incidencia</button>
                        </div>
                    </div>
        </div>
    </div>
  </div>
</div>
</form>
    <!--Fin del row -->
</section>

<script>
    ///Inicio de script del textArea de comentario
    init_contadorSmsText("smsText", "contSmsText", 300);
    init_contadorSmsText("comentario", "caracteres", 300);

    function init_contadorSmsText(idtextarea, idcontador, max) {
        $("#" + idtextarea).keyup(function() {
            updateContadorTa(idtextarea, idcontador, max);
        });

        $("#" + idtextarea).change(function() {
            updateContadorTa(idtextarea, idcontador, max);
        });
    }

    function updateContadorTa(idtextarea, idcontador, max) {
        var contador = $("#" + idcontador);
        var ta = $("#" + idtextarea);
        contador.html("Caracteres usados: " + "0 de " + max);
        contador.html("Caracteres usados: " + ta.val().length + " de " + max);
        if (parseInt(ta.val().length) > max) {
            ta.val(ta.val().substring(0, max - 1));
            contador.html("Caracteres usados: " + max + " de " + max);
        }

    }
    ///inicio de script de los input de fecha
    var fechaStartn =
        $('.fechaStart').datepicker({
            format: "yyyy-mm-dd",
            startDate: "",
            language: "es",
            autoclose: true
        });

    //scroll de la tabla 
    

</script>
<script type="text/javascript">
    document.getElementById('fechaStart').value = '<?= ($this->input->get('fechaStart', TRUE) != "") ? $this->input->get('fechaStart', TRUE) : date('Y-m-d'); ?>';
    document.getElementById('smsText').value = '';
</script>

<script>
    //script del fileupload de react
    var fileUpload = new FileUpload({
        selector: '#jfileupload', //es el id del div
        reference: 'INCIDENCIAS', // es el nombre de la referencia
        referenceId: 5,
        getFiles: '<?=base_url()?>uploaDocuments/getFiles?ref=',
        postFiles: '<?=base_url()?>incidencias/postAgregarIncidencia?files',
    });
    fileUpload.init();

    //bnUpload
    $('button[name=bnUpload]').attr("disabled");
</script>


<?php $this->load->view('footers/footer'); ?>
