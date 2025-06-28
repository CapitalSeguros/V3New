<!DOCTYPE html>
<html lang="es-MX">

<head>
    <?= link_tag('assets/img/icon.png', 'apple-touch-icon-precomposed'); ?>
    <?= link_tag('assets/img/icon.png', 'shortcut icon'); ?>
    <title>Capsys &bull; Web - Bienvenido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="<?= base_url() ?>assets/gap/css/toastr.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/gap/css/cap.css">
    <script src="<?= base_url() ?>assets/gap/js/toastr.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/gap/js/sweetalert.min.js" type="text/javascript"></script>
</head>

<body>
    <style>
        .custom {
            height: 20px !important;
            width: 20px !important;
        }

        .btn-group-sm>.btn,
        .btn-sm {
            padding: 5px 1px;
            font-size: 6px;
            line-height: 1.5;
            border-radius: 3px;
        }


        /* prueba */
    </style>
    <div class="container-fluid">
        <section class="container-fluid breadcrumb-formularios">
            <input type="hidden" name="idRegistro" id="idRegistro" value="<?= $idRegistro ?>">
            <input type="hidden" name="accion" id="accion" value="<?= $accion ?>">
            <input type="hidden" name="Usuario" id="Usuario" value="<?= $Usuario ?>">
            <input type="hidden" name="Modulo" id="Modulo" value="<?= $modulo ?>">
            <div class="row">
                <div class="col-md-6 col-sm-5 col-xs-5">
                    <h3 class="titulo-secciones" style="line-height:0px!important"><?= $accion == "DOCUMENT" ? 'DOCUMENTOS' : 'BITÁCORA' ?></h3>
                </div>

            </div>
            <hr />
            <div class="row" style="max-height: 300px;overflow:auto;height: 300px;">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row" id="contenido"></div>
                    <div class="row" id="fullDocs">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">DOCUMENTOS</a></li>
                                <li><a data-toggle="tab" href="#menu1">RECIBOS</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="row" id="insertDocs">

                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <div class="row" id="insertRec">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($accion == "BITACORA") : ?>
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <textarea placeholder="comentario" class="form-control" name="comentario" id="comentario" style="height: 50px; resize: none; overflow: hidden; margin-top: 10px;"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary" style="margin-top: 20px;" onclick="sendBitacora()">Guardar</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($accion == "DOCUMENT") : ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <select name="tipo" id="tipo" class="form-control select-sm">
                            <option value="">SELECCIONE UNA OPCION</option>
                            <option value="DOCUMENT">DOCUMENTO</option>
                            <option value="RECIBO">RECIBO</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="file" multiple='true' name="file" id="file" class="form-control fileD" style="margin-top: 5px;">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button style="width: 100%;margin-top: 5px;" class="btn btn-primary" id="DocumentoBTN" onclick="sendDocumentos()">Guardar</button>
                    </div>
                    <!-- <div>
                        <button class="btn btn-default" style="margin-top: 20px;" id="DocumentoBTN" onclick="sendDocumentos()">Guardar</button>
                    </div> -->
                </div>
            <?php endif; ?>
            <input id="urlAPI" type="hidden" value="<?=URL_TICC_SICAS?>api/">
        </section>
    </div>
    <script src="<?= base_url() ?>assets/gap/js/bootstrap.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            var accion = $("#accion").val();
            var modulo = $("#Modulo").val();
            var Id = $("#idRegistro").val();
            const $pathServicio = $("#urlAPI").val();

            var UrlServicio = $pathServicio;

            window.LoadData = function() {
                $.ajax({
                    url: UrlServicio + `capture/accionespestana?Id=${Id}&Accion=${accion}&Modulo=${modulo}`,
                    type: "GET",
                    data: {}
                }).done(function(response) {
                    //console.log(response.Datos);
                    var template;
                    switch (accion) {
                        case 'DOCUMENT':
                            var All=response.Datos;
                            var Docs=All.filter((x)=>x.TypeDestinoCDigital=='DOCUMENT');
                            var Rec=All.filter((x)=>x.TypeDestinoCDigital=='RECIBO');

                            var Template1=LoadDocuments(Docs);
                            var Template2=LoadDocuments(Rec);

                            //template = LoadDocuments(response.Datos);
                            $("#contenido").hide();
                            $("#fullDocs").show();
                            $("#insertDocs").html('');
                            $("#insertDocs").html(Template1);
                            $("#insertRec").html('');
                            $("#insertRec").html(Template2);
                            break;
                        case 'BITACORA':
                            $("#contenido").show();
                            $("#fullDocs").hide();
                            template = LoadBitacora(response.Datos);
                            $("#contenido").html('');
                            $("#contenido").html(template);
                            break;

                        default:
                            break;
                    }
                });

            }
            LoadData();

            window.LoadBitacora = function(data) {
                var template = "";
                data.forEach(element => {
                    template += `<div class="col-md-12 col-sm-12 col-xs-12" style="border: 1px solid black;margin-bottom: 5px;">
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <i class="glyphicon glyphicon-user" style="font-size:30px;cursor:pointer;text-align:center;"></i>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10" style="font-size:8px;">
                                        <div class="row">
                                            <div style="display: inline-table;">
                                            <b>${element.UserGen??'AUTOMATICO'}</b>
                                            </div>
                                            <div style="float: inline-end;">
                                                <b>${element.FechaHora}</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                          ${element.Comentario}
                                        </div>
                                    </div>
                                </div>`;
                });
                if (data.length == 0) {
                    template += `<div class="col-md-12 col-sm-12 col-xs-12" > 
                                    No hay elementos cargados.
                                </div>`
                }
                return template;
            }

            window.LoadDocuments = function(data) {
                var template = "";
                data.forEach(element => {
                    template += `<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:40px;cursor:pointer;text-align:center;">
                                    <div class="row">
                                        <div class="col-md-12">
                                         <i class="glyphicon glyphicon-file" data-toggle="tooltip" data-placement="bottom" title="${element.ListFilesURL}" onclick="OpenWindow('${element.ListFilesURL}')"></i>
                                         <p style="font-size:8px !important; text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">${element.TipoEntidad===1?element.FolderDestino:getLastItem(element.ListFilesURL)}</p>
                                         <a class="btn btn-primary btn-sm custom" onclick="DeleteDocumento(${element.Id})" style="margin-bottom:50px"><i class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></i></a>
                                        </div>
                                    </div>       
                                </div>`;
                });
                if (data.length == 0) {
                    template += `<div class="col-md-12 col-sm-12 col-xs-12" > 
                                    No hay elementos cargados.
                                </div>`
                }
                return template;
            }

            window.OpenWindow = function(URL) {
                window.open(URL, '_blank');
            }

            window.getLastItem = function(StringURL) {
                var opt = StringURL.split('/');
                return opt.pop();
            }

            window.sendBitacora = function() {
                $.ajax({
                    url: UrlServicio + `capture/addBitacora`,
                    type: "POST",
                    data: {
                        Id: Id,
                        data: {
                            Usuario: $('#Usuario').val(),
                            Comentario: $('#comentario').val(),
                            Modulo: modulo
                        }
                    }
                }).done(function(response) {
                    $('#comentario').val('');
                    LoadData();
                    toastr.success("Exíto");
                });
            }

            window.sendDocumentos = function() {
                var Tipo = $("#tipo").val();
                var Doc = 0;
                //console.log("Tipo",Tipo);
                $('#DocumentoBTN').prop('disabled', true);
                var formData = new FormData();
                formData.append('Id', Id);
                formData.append('Modulo', modulo);
                formData.append('Tipo', Tipo);
                $('.fileD').each(function(index, value) {
                    const DocFiles = $(`#${value.name}`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        Doc++;
                        formData.append(DocFiles[i].name + '_' + `(${value.name})`, DocFiles[i]);
                    }
                });

                if (Tipo == "") {
                    $('#DocumentoBTN').prop('disabled', false);
                    return toastr.error("Seleccione un tipo de documento.");
                }
                if (Doc == 0) {
                    $('#DocumentoBTN').prop('disabled', false);
                    return toastr.error("Seleccione documentos.");
                }

                $.ajax({
                    url: "<?= base_url() ?>servicioSistema/SaveDocumentos",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                }).done(function(response) {
                    //console.log('reposne',response)
                    //$('#comentario').val('');
                    $('.fileD').each(function(index, value) {
                        $(`#${value.name}`).val('').change();
                    });
                    LoadData();
                    $('#DocumentoBTN').prop('disabled', false);
                    toastr.success("Exíto");
                });
            }

            window.DeleteDocumento = function(Id) {
                //alert('test');
                $.ajax({
                    url: UrlServicio + `capture/deleteDocumento`,
                    type: "POST",
                    data: {
                        Id: Id
                    }
                }).done(function(response) {
                    toastr.success("Exíto");
                    LoadData();
                });
            }
        });
    </script>

</body>

</html>