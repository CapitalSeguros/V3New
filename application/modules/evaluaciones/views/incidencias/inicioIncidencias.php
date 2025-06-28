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
                    <li class="active">Incidencias</li>
                    <li><a href="<?=base_url()?>incidencias/tipoIncidencia">Tipos de incidencias</a></li>
                </ol>
		    </div>
        </div>
        <hr />
    </section>
</section>
<section class="container-fluid">
    <!-- aqui va el contenido del formulario -->
    <form action="<?= base_url() ?>incidencias/AgregarIncidencia" method="POST" class="form">
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
                    <input type="text" name="fechaStart" id="fechaStart" value="<?= set_value('fechaStart') ?>" class="form-control input-sm fecha fechaStart" placeholder="1900-01-01" title="Fecha de Inicio" autocomplete="off" value="<?= ($this->input->post('fechaStart', TRUE) != "") ? $this->input->post('fechaStart', TRUE) : date('Y-m-d') ?>">
                    <?= form_error('fechaStart') ?>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <label for="fechaEnd">Fecha de finalización:</label>
                    <input type="text" name="fechaEnd" id="fechaEnd" value="<?= set_value('fechaEnd') ?>" class="form-control input-sm fecha fechaEnd" placeholder="1900-01-01" title="Fecha de finalización" autocomplete="off" value="<?= ($this->input->post('fechaEnd', TRUE) != "") ? $this->input->post('fechaEnd', TRUE) : date('Y-m-d') ?>">
                    <?= form_error('fechaEnd') ?>
                </div>
            </div>
        </div><!-- /row -->
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <label for="Estatus">Escriba un comentario referente:</label>
                    <textarea style="height: 150px" id="smsText" name="smsText" class="form-control input-sm" placeholder="Escriba Aqui" value="<?= set_value('smsText') ?>"><?= $this->input->post('smsText', true) ?></textarea>
                    <p id="contSmsText">Caracteres usados: 0 de 300</p>
                    <?= form_error('smsText') ?>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <br />
                    <button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="Consultar Reporte">Registrar Incidencia</button>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <div id="jfileupload">

                    </div>
                </div>
            </div>

    </form>

    </div>
    <!--Fin del row -->
    </div><!-- fin del container-->

</section>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div style="border:solid;overflow:hidden;" id="scrollCabecera">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tipo de incidencia</th>
                                <th scope="col">Estado</th>
                                <th style="text-align: center;" scope="col">Fecha de inicio</th>
                                <th scope="col">Comentarios</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            if ($tabla != null) {
                                foreach ($tabla as $item) {
                                    $d = date('Y-m-d', strtotime($item['fecha_inicio']));
                                    if ($item['comentario_rechazo'] == null) {
                                        $coment = "En revisión";
                                    } else {
                                        $coment = $item['comentario_rechazo'];
                                    }
                                    $tds = "";
                                    $fechaincidencia="<input id='incd_".$item['idincidencias']."' type='text' value='".$item['fecha_inicio']."' style='display:none'></input>";
                                    //$elemento=explode(" ",$item['fecha_inicio']);
                                    //$fecha='\''.$elemento[0].'\'';
                                    $tds = "<th>" . $item['nombre'] . "</th>" . "<th>" . $item['estatus'] . "</th>" . "<th style='text-align: center;''>" . $d . "</th>" . "<th>" . $coment . "</th>";
                                    $botones = "<th><button class='btn btn-primary' onclick='getInfoIncidencia(" . $item['idincidencias'] . "," . $item['empleado_id'] . ")' >Ver información</button>".$fechaincidencia."</th>";
                                    echo "<tr>" . $tds . $botones ."</tr>";
                                    //	y "-" mm "-" dd
                                }
                            } else {
                                $mensaje = ' 
                                                <th ></th>
                                                <td colspan="2" style="text-align: center;">No tienes registros aún</td>
                                                <td></td>';
                                echo "<tr>" . $mensaje . "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- panel-body -->
</div><!-- panel-default -->

<!-- Modal -->
<div id="mymodal" class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header titulos">
                <h4 class="modal-title" id="exampleModalLabel">Información de la incidencia:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Titular:</label>
                                <div id="nombre"></div>
                                <input type="text" id="id_incidencia" name="id_incidencia" style="display:none">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Fecha de inicio:</label>
                                <div id="inicio"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Duración en días:</label>
                                <div id="dias"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Tipo de incidencia:</label>
                                <div id="tipo"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Comentario:</label>
                                <div id="comentario"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Fecha de subida:</label>
                                <div id="subida"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Documentos:</label>
                                <div id="documentos"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="respuestaContenido">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label titulos">Acciones a realizar:</label>
                                <select onchange="validarComentario()" name="accion" id="accion" class="form-control input-sm is-invalid" required>
                                    <option selected disabled >Seleccione una opción</option>
                                    <option value="1" name="aprobar">APROBAR</option>
                                    <option value="2" name="rechazar">RECHAZAR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="Estatus">Escriba un comentario referente:</label>
                                <textarea disabled required style="height: 150px" id="comentario" name="comentario" class="form-control input-sm" placeholder="Escriba Aqui" value="<?= set_value('smsText') ?>"><?= $this->input->post('smsText', true) ?></textarea>
                                <?= form_error('smsText') ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <br />
                                <button id="enviar" disabled onclick="ValidaciondeIncidencia()" class="btn btn-primary">Enviar respuesta</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-12">
                            <div class="form-group">
                                <div class="alert alert-success alert-dismissible hidden" id="myAlert">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
            <!--final del form modal-->
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" onclick="recharge()"  data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
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

    var fechaEndn =
        $('.fechaEnd').datepicker({
            format: "yyyy-mm-dd",
            startDate: "",
            language: "es",
            autoclose: true
        });

    //scroll de la tabla 
    function moverScroll() {
        var elmnt = document.getElementById("scrollTabla");
        var x = elmnt.scrollLeft;
        document.getElementById("scrollCabecera").scrollLeft = x;
    }


    ///eventos de la tabla para la validación de las incidencias;
    function getInfoIncidencia(id, usr, fecha) {
        //let newFecha=getFecha(fecha);
        let variable=$('input[id=incd_'+id+']').val();
        let str=variable.split(' ');
        //console.log(str[0]);
        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>incidencias/datosInicidencia",
            data: {
                'id': id,
                'usr': usr,
                'fecha': str[0]
            },
            success: function(data) {
                var json = JSON.parse(data);
                console.log(json);
                cleanhtml();
                $('div[id=nombre]').append(json.data[0].name_complete);
                $('div[id=comentario]').append(json.data[0].comentario);
                $('div[id=inicio]').append(getFecha(json.data[0].fecha_inicio));
                $('div[id=dias]').append(json.data[0].dias + " Días");
                $('div[id=tipo]').append(json.data[0].nombre);
                $('div[id=subida]').append(getFecha(json.data[0].fecha_alta));
                $('div[id=documentos]').append(documentsList(json.documentos));
                $('input[id=id_incidencia]').val(json.data[0].idincidencias);
                if(json.data[0].estatus=="AUTORIZADO"||json.data[0].estatus=="RECHAZADO"){
                    $('div[id=respuestaContenido]').hide();
                }
                $('#mymodal').modal('show');
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

    }

    function cleanhtml() {
        $('div[id=nombre]').empty();
        $('div[id=comentario]').empty();
        $('div[id=inicio]').empty();
        $('div[id=dias]').empty();
        $('div[id=tipo]').empty();
        $('div[id=subida]').empty();
        $('div[id=documentos]').empty();
    }

    function documentsList(data) {
        let contenido = "";
        let res = "";
        $.each(data, function(key, value) {
            //console.log(value.nombre_completo);
            contenido += "<a href='" + value.ruta_completa + "' download='" + value.nombre_completo + "' target='_blank' >" + value.nombre_completo + "</a></br>";
        });
        return contenido;
    }

    function getFecha(date) {
        let arreglo = date.split(' ');
        let str = arreglo[0];
        return str;
    }

    function validarComentario(){
        let select= $('select[id=accion]').val();
        console.log(select);
        if(select==2){
            $('textarea[id=comentario]').attr("required");
            $('textarea[id=comentario]').removeAttr("disabled");
            $('button[id=enviar]').removeAttr("disabled");
        }else{
            $('textarea[id=comentario]').removeAttr("required");
            $('textarea[id=comentario]').removeAttr("disabled");
            $('button[id=enviar]').removeAttr("disabled");
        }
    }

    function ValidaciondeIncidencia(){
        let comentario=$('textarea[id=comentario]').val();
        let idincidencia=$('input[id=id_incidencia]').val();
        let accion=$('select[id=accion]').val();

        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>incidencias/gestionIncidencia",
            data: {
                'comentario':comentario,
                'id':idincidencia,
                'accion':accion
            },
            beforeSend: function () {
                $('label[id=status]').append("Procesando, espere por favor...");
            },
            success: function(data) {
                //$('div[id=status]').show();
                var json = JSON.parse(data);
                $('div[id=myAlert]').append(json.mensaje);
                $('div[id=myAlert]').removeClass('hidden');
                //$("#status").html(json.mensaje);
                console.log(json.mensaje);
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

        //console.log('respuesta:'+comentario+idincidencia+accion);
    }

    function recharge(){
        location.reload();
    }

</script>
<script type="text/javascript">
    document.getElementById('fechaStart').value = '<?= ($this->input->get('fechaStart', TRUE) != "") ? $this->input->get('fechaStart', TRUE) : date('Y-m-d'); ?>';
    document.getElementById('fechaEnd').value = '<?= ($this->input->get('fechaEnd', TRUE) != "") ? $this->input->get('fechaEnd', TRUE) : date('Y-m-d'); ?>';
    document.getElementById('smsText').value = '';
</script>

<script>
    //script del fileupload de react
    var fileUpload = new FileUpload({
        selector: '#jfileupload', //es el id del div
        reference: 'INCIDENCIAS', // es el nombre de la referencia
        referenceId: 5,
        getFiles: 'uploaDocuments/getFiles?ref=',
        postFiles: 'uploaDocuments/uploadFile?files',
    });
    fileUpload.init();
</script>


<?php $this->load->view('footers/footer'); ?>