<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?= link_tag('assets/img/icon.png', 'apple-touch-icon-precomposed'); ?>
    <?= link_tag('assets/img/icon.png', 'shortcut icon'); ?>
    <title>Capsys &bull; Web - Carga de Documentos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/documentos_app/css/ticc.css">

</head>
<?php
$CI = &get_instance();
$CI->load->library("docgeneral");
?>

<body id="body">
    <div class="formD">
        <div class="main">
            <div class="row">
                <div class="col-md-12">
                    <img src="https://www.capitalsegurosgmm.com/img/logo.png" alt="" height="50px" width="20%">
                </div>
                <div class="col-md-12">
                    <h1 style="font-weight: 500;">Carga de documentos para el trámite: <?= $siniestro[0]["nombre_tramite"] ?></h1>
                    <hr />
                    <p>
                        Este apartado es para que usted pueda subir sus documentos de acuerdo al trámite que este solicitando.
                    </p>
                </div>
                <div class="col-md-12">
                    <h4 style="font-weight: 600;">Información general</h4>
                    <?php
                    $complemento = json_decode($siniestro[0]["complemento_json"], true);
                    ?>
                    <div class="col-xs-3 col-md-3">
                        <h5 style="font-weight: 600;">Afectado:</h5> <?= $complemento["general"]['afectado'] ?>
                    </div>
                    <div class="col-xs-3 col-md-3">
                        <h5 style="font-weight: 600;">Número siniestro:</h5> <?= $siniestro[0]["siniestro_id"] ?>
                    </div>
                    <div class="col-xs-3 col-md-3">
                        <h5 style="font-weight: 600;">Póliza:</h5><?= $siniestro[0]["poliza"] ?>
                    </div>
                    <div class="col-xs-3 col-md-3">
                        <h5 style="font-weight: 600;">Folio CIA:</h5><?= $siniestro[0]["folio_cia"] ?>
                    </div>
                </div>
                <div class="hide">
                    <input type="hidden" name="id_siniestro" id="id_siniestro" value="<?= $siniestro[0]["id"] ?>">
                    <input type="hidden" name="tipo_tramite" id="tipo_tramite" value="<?= $siniestro[0]["tipo_tramite"] ?>">
                    <input type="hidden" name="id_tram" id="id_tram" value="<?= $siniestro[0]["id_tramite"] ?>">
                    <input type="hidden" name="acess" id="acess" value="<?= $access ?>">
                </div>
            </div>
        </div>
        <?php if ($siniestro[0]["estatus_doc_revision"] == null || ($siniestro[0]["estatus_doc_revision"] != "REVISION"  && $siniestro[0]["estatus_doc_revision"] != "ACTIVO")) : ?>
            <?php foreach ($documentos_carga as $value) : ?>
                <?php
                $filterBy = $value["id_tipo_documento"];
                $doc_up_view = array_filter($up_documents, function ($var) use ($filterBy) {
                    return ($var['revision'] == $filterBy);
                });
                $keysDocsbyTipo = array_keys($doc_up_view);
                ?>
                <div class="element">
                    <h3 style="font-weight: 600;"><?= $value["documento_nom"] ?></h3>
                    <?php $idInput = "dropcontainer_{$value["id_tipo_documento"]}_{$value["tramite"]}"; ?>
                    <?php if (count($keysDocsbyTipo)) : ?>
                        <?php if ($doc_up_view[array_keys($doc_up_view)[0]]["estado"] != "ACTIVO") : ?>
                            <label for="images" class="drop-container" id="dropcontainer_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>">
                                <span class="drop-title">Arrastre los archivos</span>
                                ó
                                <input type="file" name="<?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>" id="<?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>" class="inputf fileD" accept="*" multiple onchange="listadoc('<?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>')">
                                <div class="col-md-12 <?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>_lista"></div>
                            </label>
                        <?php endif; ?>
                    <?php else : ?>
                        <label for="images" class="drop-container" id="dropcontainer_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>">
                            <span class="drop-title">Arrastre los archivos</span>
                            ó
                            <input type="file" name="<?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>" id="<?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>" class="inputf fileD" accept="*" multiple onchange="listadoc('<?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>')">
                            <div class="col-md-12 <?= $CI->docgeneral->slugify($value["documento_nom"], "_") ?>_<?= $value["id_tipo_documento"] ?>_<?= $value["tramite"] ?>_lista"></div>
                        </label>
                    <?php endif; ?>
                    <?php if (count($doc_up_view) > 0) : ?>
                        <div>
                            <div>
                                <H5 style="font-weight: 600;"> Elementos cargados</H5>
                            </div>
                            <div>
                                <?php foreach ($doc_up_view as $item) : ?>
                                    <div id="doc_<?= $item['file_id'] ?>" class='col-xs-2 padre' style='border: 2px solid black; margin-left:5px; margin-bottom:5px; font-size: 10px;'>
                                        <div class='hijo truncate-overflow'>
                                            <img src="<?= $CI->docgeneral->GetIcon($item["tipo"]) ?>" style="width:20px;height:20px;margin-left: 40%;"></img>
                                            <br /><?= $item["nombre_completo"] ?>
                                            <div class="row" style="display:flex; <?= $doc_up_view[array_keys($doc_up_view)[0]]["estado"] != "ACTIVO" ? 'margin-left:5px' : 'margin-left:35%' ?>">
                                                <a class="btn btn-xs btn-primary" onclick="window.open(' <?= $item['ruta'] ?>', 'hello', 'width=600,height=600');"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                                <?php if ($doc_up_view[array_keys($doc_up_view)[0]]["estado"] != "ACTIVO") : ?>
                                                    <a class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true" onclick="DeleteDoc('<?= $item['file_id'] ?>')"></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php if ($siniestro[0]["estatus_doc_revision"] == "INCORRECTO") : ?>
                <div class="element">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6">
                            <h3 style="font-weight: 600;">Observaciones del agente:</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?= $siniestro[0]["comentario_doc"] ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="submit">
                <a class="save buttonf btn btn-sm" data-tipo="1">Guardar</a>
                <a class="save buttonf btn btn-sm" data-tipo="2">Enviar</a>
            </div>
        <?php else : ?>
            <?php if ($siniestro[0]["estatus_doc_revision"] != "ACTIVO") : ?>
                <div class="element">
                    Tus documentos estan siendo validados por un agente.
                </div>
            <?php else : ?>
                <div class="element">
                    Los documentos fueron validados correctamente.
                </div>
                <?php foreach ($documentos_carga as $value) : ?>
                    <div class="element">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-lg-6">
                                <h3 style="font-weight: 600;"><?= $value["documento_nom"] ?></h3>
                            </div>
                        </div>

                        <?php $idInput = "dropcontainer_{$value["id_tipo_documento"]}_{$value["tramite"]}"; ?>
                        <?php
                        $filterBy = $value["id_tipo_documento"];
                        $doc_up_view = array_filter($up_documents, function ($var) use ($filterBy) {
                            return ($var['revision'] == $filterBy);
                        });
                        ?>
                        <?php if (count($doc_up_view) > 0) : ?>
                            <div>
                                <div>
                                    <H5 style="font-weight: 600;"> Elementos cargados</H5>
                                </div>
                                <div>
                                    <?php foreach ($doc_up_view as $item) : ?>
                                        <div class='col-xs-2 padre' style='border: 2px solid black; margin-left:5px; margin-bottom:5px; font-size: 10px;'>
                                            <div class='hijo truncate-overflow'>
                                                <img src="<?= $CI->docgeneral->GetIcon($item["tipo"]) ?>" style="width:20px;height:20px;margin-left: 40%;"></img>
                                                <br /><?= $item["nombre_completo"] ?>
                                                <div class="row" style="display: flex;margin-left:35%">
                                                    <a class="btn btn-xs btn-primary" onclick="window.open(' <?= $item['ruta'] ?>', 'hello', 'width=600,height=600');"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                                    <!-- <a class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></a> -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>

        <p class="policy">
            Todos los datos anexados a este pagina son revisados por un agente de seguro.
            <a href="#">Terminos y condiciones.</a>
            <a href="#">Politica de privacidad.</a>
        </p>
        <div class="overlay" id="backdrop" style="display: none;">
            <div class="d-flex justify-content-center" style="margin-left: 50%;">
                <div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>
            </div>
        </div>
    </div>

    <footer id="footer">
        <div style="padding-top: 10px; font-size: 20px;">Capital Seguros y Fianzas. © <?= date("Y") ?></div>
    </footer>
    <script type="text/javascript">
        <?= $documentos ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {

            var Url = "<?= base_url() ?>";
            $('#backdrop').css("height", $("#body").height());
            const dropContainer = document.getElementById("dropcontainer");
            const fileInput = document.getElementById("images");

            $(document).on('dragover', '.drop-container', function(e) {
                //console.log("dragover",e)
                e.preventDefault()
            }, false);

            $(document).on('dragenter', '.drop-container', function(e) {
                //console.log("dragenter",e)
                this.classList.add("drag-active");
            });

            $(document).on('dragleave', '.drop-container', function(e) {
                //console.log("dragleave",e)
                this.classList.remove("drag-active");
            });

            $(document).on('drop', '.drop-container', function(e) {
                e.preventDefault()
                e.stopPropagation();
                this.classList.remove("drag-active")
                var Find = document.getElementById(e.target.id).getElementsByClassName("inputf")[0];
                const fileInput = document.getElementById(Find.id);
                fileInput.files = e.originalEvent.dataTransfer.files;
                listadoc(Find.id);

            });

            $(document).on('click', '.save', function(e) {
                //console.log("button", e)
                //$(".overlay").css("display", "block");
                SaveDocs(e.target.dataset.tipo);

            });

            window.FixFooter = function() {
                var numItems = $("body").height();
                console.log("Total", numItems)
                if (numItems > 600) {
                    $('#footer').css("bottom", "-1");
                    console.log("aa", 1)
                } else {
                    console.log("aa", 2)
                    $('#footer').css("bottom", "0");
                }
            }
            FixFooter();


            //Mostar el nombre de los archivos subidos
            window.listadoc = function(id, tipo = null) {
                error = [];
                //console.log("element",id)
                //console.log("element",$(`${id}`))
                const DocFiles = document.getElementById(id).files;
                var content = '';
                //var content='<ul style="padding-left:20px;">';
                for (var i = 0; i < DocFiles.length; i++) {
                    content += `<div class='col-xs-2 padre' style='border: 2px solid black; margin-left:5px; margin-bottom:5px;'>
                    <div class='hijo truncate-overflow'>
                        <img src="${getIcon(DocFiles[i].name)}" style="width:20px;height:20px;margin-left: 40%;"></img>
                        <br/>${DocFiles[i].name}
                        </div>
                    </div>`;
                }
                var lista = tipo == null ? `.${id}_lista` : `.${id}_lista_doc`;
                $(lista).html('');
                $(lista).html(content);
            }

            window.getIcon = function(name) {
                let _icons_multi_upload = {
                    pdf: Url + "assets/img/icons/pdf.png",
                    word: Url + "assets/img/icons/word.png",
                    excel: Url + "assets/img/icons/excel.png",
                    pic: Url + "assets/img/icons/other.png",
                };
                cIcon = '';
                if (name.indexOf(".pdf") >= 0) {
                    cIcon = _icons_multi_upload.pdf;
                } else if (name.indexOf(".doc") >= 0 || name.indexOf(".docx") >= 0) {
                    cIcon = _icons_multi_upload.word;
                } else if (name.indexOf(".xls") >= 0 || name.indexOf(".xlsx") >= 0) {
                    cIcon = _icons_multi_upload.excel;
                } else {
                    cIcon = _icons_multi_upload.pic;
                }
                return cIcon;
            }

            window.SaveDocs = function(tipo) {
                $(".overlay").css("display", "block");
                var formData = new FormData();
                formData.append('id_siniestro', $("#id_siniestro").val());
                formData.append('tipo_tramite', $("#tipo_tramite").val());
                formData.append('id_tram', $("#id_tram").val());
                formData.append('acess', $("#acess").val());
                formData.append('tipo', tipo);

                $('.fileD').each(function(index, value) {
                    //console.log("nombre", value.name)
                    const DocFiles = $(`#${value.name}`).prop('files');
                    //console.log("Files",DocFiles);
                    for (var i = 0; i < DocFiles.length; i++) {
                        formData.append(DocFiles[i].name + '_' + `${value.name}`, DocFiles[i]);
                    }
                });

                if (tipo == 2) {
                    swal({
                        title: "¿Está seguro de enviar los documentos a revisión?",
                        text: "Una vez enviado, ¡no podrá modificarlos hasta su revision por el agente!",
                        icon: "warning",
                        //content:"<select><option>TEST</option></select>",
                        buttons: ["Cancelar", "Aceptar"],
                    }).then((value) => {
                        if (value) {
                            SaveAll(formData);
                        }
                    });
                } else {
                    SaveAll(formData);
                }
            }


            window.SaveAll = function(data) {
                $.ajax({
                    url: `${Url}documentos/SaveDocumentos/`,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if (response.code == 200) {
                            toastr.success("Se guardo con éxito.");
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                        $(".overlay").css("display", "none");
                    }
                });
            }

            window.DeleteDoc = function(id) {
                $(".overlay").css("display", "block");
                var formData = new FormData();
                formData.append('id', id);

                $.ajax({
                    url: `${Url}documentos/deleteDoc/`,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        if (response.code == 200) {
                            toastr.success("Se realizó con éxito.");
                            $(`#doc_${id}`).remove();
                        } else {
                            toastr.error(response.message);
                        }
                        $(".overlay").css("display", "none");
                    }
                });
            }


            /* dropContainer.addEventListener("dragover", (e) => {
                // prevent default to allow drop
                e.preventDefault()
            }, false) */

            /* dropContainer.addEventListener("dragenter", () => {
                dropContainer.classList.add("drag-active")
            }) */

            /* dropContainer.addEventListener("dragleave", () => {
                dropContainer.classList.remove("drag-active")
            }) */

            /* dropContainer.addEventListener("drop", (e) => {
                e.preventDefault()
                dropContainer.classList.remove("drag-active")
                fileInput.files = e.dataTransfer.files
            }) */
        });
    </script>

</body>

</html>