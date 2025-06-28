<div class="col-md-12 bt-table tab-pane tab-panel4" id="PanelP4" style="padding: 0px; margin-bottom: 0px;">
    <div class="col-md-12 content-detalles">
        <div class="segment-p-detalles" style="height: 100%;">
            <div class="modal-header segment-header-detalles">
                <h4 class="title-result">Nuevo mensaje de correo electrónico</h4>
            </div>
            <div class="content-send-email" id="SpinnerDocCDContent"></div>
            <div class="modal-body segment-body-detalles" id="Content-Envio-Correo" style="padding: 10px 10px 0px 10px; height: 480px;">
                <!-- <div class="panel-btn-recibo title-table">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-panel-recibo btn-sup-left" style="">
                            <i class="fa fa-envelope" style="padding-right:5px;"></i>
                            Enviar Correo
                        </button>
                        <button type="button" class="btn btn-panel-recibo">
                            <i class="fa fa-pencil-square-o" style="padding-right:5px;"></i>
                            Destinatarios Relacionados
                        </button>
                        <div class="dropdown" id="Dropdown-Email" style="display: contents;">
                            <button class="btn btn-panel-recibo dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-text" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">POLIZA CON RENOVACIÓN</a></li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <nav class="navbar navbar-expand-md panel-btn-recibo title-table" style="padding:0px; min-height:auto; opacity:.9;">
                    <div class="collapse" style="visibility: visible;display: contents;">
                        <ul class="navbar-nav nav-align-items" style="margin: 0px;">
                            <!-- height: 31.14px; 0880329623 39491972-8-->
                            <li class="nav-item">
                                <a class="nav-link btn-panel-recibo btn-sup-left" id="Enviar" style="padding: 6px 12px;">
                                    <i class="fa fa-envelope" style="padding-right:5px;"></i>
                                    <span class="name-item-email">Enviar Correo</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn-panel-recibo" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                                    <i class="fa fa-address-book-o" style="padding-right:5px;"></i>
                                    <span class="name-item-email">Destinatarios Relacionados</span>
                                </a>
                                <div class="dropdown-menu" id="CorreoCliente" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" data-email="">Ninguno</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn-panel-recibo" id="navbarDropdown" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                                    <i class="fa fa-address-book" style="padding-right:5px;"></i>
                                    <span class="name-item-email">Remitentes Disponibles</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="CorreoEmpleado" aria-labelledby="navbarDropdown" style="width: 465px; height: 200px; overflow: auto;">
                                    <?php echo(ImprimirCorreos($empleados));?>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn-panel-recibo" title="Insertar archivo" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                                    <i class="fa fa-paperclip" style="padding-right:5px;"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="SubirArchivos" aria-labelledby="navbarDropdown">
                                    <button class="dropdown-item hidden" id="FileExp">
                                        <i class="fa fa-desktop" aria-hidden="true"></i>
                                        Mis Documentos
                                    </button>
                                    <button class="dropdown-item" id="FileCD" disabled>
                                        <div class="content-upload-spinner" id="SpinnerDocCD"></div>
                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                        Centro Digital
                                    </button>
                                    <button class="dropdown-item hidden" id="DeleteFiles">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        Borrar archivos
                                    </button>
                                </div>
                            </li>
                            <li class="nav-item dropdown" id="PlantillasCorreo" style="height: 31.14px;">
                                <a class="nav-link dropdown-toggle btn-panel-recibo" role="button" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                                    <i class="fa fa-sticky-note" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <button class="dropdown-item" id="PlantillaRenovacion" onclick="CargarPlantilla()" disabled>
                                        <div class="content-email-spinner" id="SpinnerEmail"></div>
                                        POLIZA CON RENOVACIÓN
                                    </button>
                                </div>
                            </li>
                            <!-- <li class="nav-item hidden">
                                <a class="nav-link btn-panel-recibo" style="padding: 6px 12px;">
                                    <i class="fa fa-pencil-square-o" style="padding-right:5px;"></i>
                                    Destinatarios Relacionados
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </nav>
                <div class="col-md-12 column-comision" style="overflow: auto; height: 430px; margin-bottom: 0px;">
                    <form action="<?=base_url()?>polizas/DatosCorreo" id="FormSE" enctype="multipart/form-data" method="post">
                    <div class="col-md-12 space-bottom-r" style="margin-bottom: 0px;">
                        <div class="space-bottom-r input-group" style="display:flex;">
                            <label class="input-group-text label-destiny input-width">Para</label>
                                <input type="text" id="cPara" name="e1" class="form-control input-sm textSearch input-email" style="width: 0px;">
                        </div>
                        <div class="space-bottom-r input-group" style="display:flex;">
                            <label class="input-group-text label-destiny input-width">De</label>
                                <input type="text" id="cDe" name="e2" class="form-control input-sm textSearch input-email" style="width: 0px;"> <!-- readonly -->
                        </div>
                        <div class="space-bottom-r input-group" style="display:flex;">
                            <label class="input-group-text label-destiny input-width">Asunto</label>
                                <input type="text" id="cAsunto" name="sj" class="form-control input-sm textSearch input-email" style="width: 0px;">
                        </div>
                        <div class="space-bottom-r input-group hidden" style="display:flex;">
                            <label class="input-group-text label-destiny input-width">ID Documento</label>
                                <input type="text" id="cIDDocto" name="dc" class="form-control input-sm textSearch input-email" style="width: 0px;">
                        </div>
                        <div class="space-bottom-r input-group hidden" style="display:flex;">
                            <label class="input-group-text label-destiny input-width">ID Cliente</label>
                                <input type="text" id="cIDCli" name="cl" class="form-control input-sm textSearch input-email" style="width: 0px;">
                        </div>
                    </div>
                    <div class="col-md-12 container-email" id="BodyEmail" style="margin-bottom: 5px;">
                        <div class="panel-btn-envio-correo title-table">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-panel-correo btn-email" id="TextBold" title="Negrita">
                                    <i class="fa fa-bold" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextItalic" title="Cursiva">
                                    <i class="fa fa-italic" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextSubr" title="Subrayado">
                                    <i class="fa fa-underline" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextLine" title="Tachado">
                                    <i class="fa fa-strikethrough" aria-hidden="true"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-panel-correo" id="TextSubI" title="Subíndice">
                                    <i class="fa fa-subscript" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextSupI" title="Superíndice">
                                    <i class="fa fa-superscript" aria-hidden="true"></i>
                                </button> -->
                                <button type="button" class="btn btn-panel-correo" id="TextFormat" title="Borrar formato">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextLeft" title="Alinear a la izquierda">
                                    <i class="fa fa-align-left" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextCenter" title="Alinear al centro">
                                    <i class="fa fa-align-center" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextRight" title="Alinear a la derecha">
                                    <i class="fa fa-align-right" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextJust" title="Justificar">
                                    <i class="fa fa-align-justify" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextSelect" title="Seleccionar todo">
                                    <i class="fa fa-i-cursor" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextUndo" title="Deshacer">
                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextRedo" title="Rehacer">
                                    <i class="fa fa-share" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextCopy" title="Copiar">
                                    <i class="fa fa-files-o" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo" id="TextCut" title="Cortar">
                                    <i class="fa fa-scissors" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo hidden" id="TextPage">
                                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-panel-correo hidden" id="QuitarP" title="Quitar plantilla">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <span class="hidden" id="TipoCorreo">1</span>
                        <div class="col-md-12 body-email" id="PlantillaR">
                            <div class="input-text-email" id="TextBodyEmail"></div>
                        </div>
                    </div>
                        <input type="text" class="col-md-12 success-email hidden" id="TextEndEmail" name="bd" style="margin-bottom: 5px;">
                        <span class="hidden" id="TipoDocEnvio">0</span>
                    <div class="col-md-12 success-email" id="StatusEmail"></div>
                        <div class="col-md-12 success-email hidden" style="margin-top: 5px;">
                            <input type="file" name="adjunto[]" id="AddFiles" multiple/>
                            <button type="submit" class="btn btn-primary" id="FormBtnSend">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        const text = document.getElementById('TextBodyEmail');
        const select = document.getSelection();
        const archivo = document.getElementById('AddFiles');
        let files;

        $('#FileCD').click(function() {
            $(".docs-centrodigital-modal").modal({
                show: true,
                keyboard: false,
                backdrop: false,
            });
        })

        $('#TextBold').click(function() {
            if(text.toString()!==''){
                document.execCommand('bold');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextItalic').click(function() {
            if(text.toString()!==''){
                document.execCommand('italic');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextSubr').click(function() {
            if(text.toString()!==''){
                document.execCommand('underline');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextLine').click(function() {
            if(text.toString()!==''){
                document.execCommand('strikeThrough');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextSubI').click(function() {
            if(text.toString()!==''){
                document.execCommand('subscript');
            }
        })

        $('#TextSupI').click(function() {
            if(text.toString()!==''){
                document.execCommand('superscript');
            }
        })

        $('#TextFormat').click(function() {
            if(select.toString()!==''){
                document.execCommand('removeFormat');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextLeft').click(function() {
            if(text.toString()!==''){
                document.execCommand('justifyLeft');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextCenter').click(function() {
            if(text.toString()!==''){
                document.execCommand('justifyCenter');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextRight').click(function() {
            if(text.toString()!==''){
                document.execCommand('justifyRight');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextJust').click(function() {
            if(text.toString()!==''){
                document.execCommand('justifyFull');
            }
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextSelect').click(function() {
            if(text.toString()!==''){
                document.execCommand('selectAll');
            }
        })

        $('#TextUndo').click(function() {
            if(text.toString()!==''){
                document.execCommand('undo');
            }
        })

        $('#TextRedo').click(function() {
            if(text.toString()!==''){
                document.execCommand('redo');
            }
        })

        $('#TextCopy').click(function() {
            if(select.toString()!==''){
                document.execCommand('copy');
            }
        })

        $('#TextCut').click(function() {
            if(select.toString()!==''){
                document.execCommand('cut');
            }
        })

        $('#TextPage').click(function() {
            if(text.toString()!==''){
                document.execCommand('paste');
            }
        })

        $('#QuitarP').click(function() {
            const content =  document.getElementById('TextBodyEmail');
            content.style.padding = "15px";
            $('#TipoCorreo').text("1");
            $('#QuitarP').addClass('hidden');
            $(content).html("");
            $('#TextEndEmail').val("");
            //contenteditable="true"
        })

        $('#TextBodyEmail').keyup(function(e) {
            const letter = document.getElementById('TextBodyEmail').innerHTML;
            $('#TextEndEmail').val(letter);
        })

        $('#TextBodyEmail').click(function() {
            //const letter = document.getElementById('TextBodyEmail').innerHTML;
            //$('#TextEndEmail').val(letter);
            //console.log(letter);
        })

        $('#FileExp').click(function() {
            archivo.click();
        });

        $(archivo).change(function() {
            files = this.files;
            changeFiles(files);
            if (files != null) {
                $('#DeleteFiles').removeClass('hidden');
            }
            else {
                $('#DeleteFiles').addClass('hidden');
            }
            //document.getElementById('StatusEmail').innerHTML = "";
        })

        $('#DeleteFiles').click(function() {
            //Restaura el valor en el input file
            archivo.value = "";
            $('#DeleteFiles').addClass('hidden');
            document.getElementById('StatusEmail').innerHTML = "";
        })

        $('#Enviar').click(function() {
            //$('#FormBtnSend').click();
            EnviarMensaje();
    })
        
        //Validación del formulario pero no se utilizan las reglas y sólo se envía
        //Es el envío de un form por ajax, no acepta documentos
        //La diferencia con el Submit común es que permite el envío de los datos de forma desglosada
        /*$("#FormSE").validate({
            submitHandler: function(form) {
                const para = document.getElementById('cPara').value;
                const de = document.getElementById('cDe').value;
                const asunto = document.getElementById('cAsunto').value;
                const idDoc = document.getElementById('cIDDocto').value;
                const idCli = document.getElementById('cIDCli').value;
                const tipo = document.getElementById('TipoCorreo').innerHTML;
                const textCorreo = document.getElementById('TextBodyEmail').innerHTML;
                cuerpo = textCorreo;

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: {
                        e1: de,
                        e2: para,
                        sj: asunto,
                        bd: cuerpo,
                        dc: idDoc,
                        cl: idCli
                    },
                    success: (data) => {
                            //const res = JSON.parse(data);
                            console.log(data);
                            swal("¡Enviado!", "Correo envido exitósamente.", "success");
                            //window.location.reload();
                        },
                    error: (error) => {
                        swal("¡Uups!", "Hay problemas al intentar enviar el correo.", "error");
                    }            
                });
            }
        });*/

        //Envío todos los datos del Form por ajax aceptando los documentos
        //La diferencia con el Submit común es que se manda por ajax
        $("#FormSE").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById("FormSE"));
            $.ajax({
                url: `<?=base_url()?>polizas/DatosCorreo`,
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: (load) => {
                    $('#SpinnerDocCDContent').html(`
                        <div class="container-spinner-content-tab-send-email">
                            <div class="cr-spinner spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <p class="cr-cargando" style="font-size:18px;">Enviando...</p>
                        </div>
                    `);
                },
                success: (data) => {
                        const res = JSON.parse(data);
                        console.log(res);
                        $('#SpinnerDocCDContent').html("");
                        if (res == "Enviado") {
                            swal("¡Enviado!", "Correo envido exitósamente.", "success");
                        }
                        else if (res == "Error") {
                            swal("¡Vaya!", "Ocurrió un confilcto al enviar el correo.", "error");
                        }
                        //window.location.reload();
                    },
                error: (error) => {
                    swal("¡Uups!", "Hay problemas al intentar enviar el correo.", "error");
                }            
            })
            /*.done(function(res){
            })*/
        })
    });

    function SelectEmailD(email) {
        const correo = $(email).data('email');
        $('#cPara').val(correo);
    }

    function SelectEmailR(email) {
        const correo = $(email).data('email');
        const nombre = $(email).data('name');
        $('#cDe').val(nombre + " " + "<"+correo+">");
    }

    function changeFiles(files) {
        if (files.length == undefined){
            showFiles(files);
        }
        else {
            for (const file of files) {
                showFiles(file);
            }
        }
    }

    function showFiles(file) {
        const tipo = file.type;
        const reader = new FileReader();
        const id = `file-${Math.random().toString(32).substring(7)}`;
        const s = Number(file.size)/1024;
        const t = s.toFixed(0);
        const d = new Date(file.lastModifiedDate);
        var icon = IconType(tipo);
        var size = SizeType(t);
        var date = nombredias[d.getDay()] + " de " + d.getDate() + " " + nombremeses[d.getMonth()] + " de " + d.getFullYear() + " " + d.toLocaleTimeString('en-US');
        console.log(file,size);
        $(reader).load(function() {
            const url = reader.result;
            const cont = `
                <div id="${id}" class="container-file">
                    <div class="col-md-11 content-tab-r1" draggable="true">
                        <i class="fa ${icon}" aria-hidden="true"></i>
                        <!-- <img src="${url}" style="width:20px;height20px;"> -->
                        <div class="dr">
                            <span class="text-file-exp" title="${file.name}">${file.name}</span>
                            <span class="subtext-file-exp" title="${date}">${date}</span>
                            <span class="subtext-file-exp" title="${size}">${size}</span>
                        </div>
                    </div>
                    <!-- <div class="col-md-1 content-btn-file">
                        <button type="button" data-id="${id}" class="btn-close-file" onclick="DeleteFile(this)">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div> -->
                </div>`;

            const view = document.getElementById('StatusEmail').innerHTML;
            document.getElementById('StatusEmail').innerHTML = cont + view;
        })
        reader.readAsDataURL(file);
    }

    function DeleteFile(btn) {
        //Elimina la vista del archivo en el panel pero no del input file
        //Los input file múltiple no pueden eliminar archivos uno por uno, deben ser todos
        const id = $(btn).data('id');
        let eliminar = document.getElementById(id).parentNode;
        eliminar.removeChild(document.getElementById(id));
    }

    function EnviarMensaje() {
        const tipo = document.getElementById('TipoCorreo').innerHTML; //Tipo 1: Normal, Tipo 2: Plantilla
        const para = document.getElementById('cPara').value;
        const de = document.getElementById('cDe').value;
        const asunto = document.getElementById('cAsunto').value;
        const idDoc = document.getElementById('cIDDocto').value;
        const idCli = document.getElementById('cIDCli').value;

        console.log("Para: "+para+", De: "+de+", Asunto: "+asunto);

        if (para != 0 && de !=0) {
            if (asunto == "") {
                swal({
                    title: "¿Desea enviarlo?",
                    text: "Se mandará sin asunto.",
                    icon: "warning",
                    buttons: ["Cancelar", "Aceptar"],
                }).then((value) => {
                    if (value) {
                        EstructuraEnvio(para,de,asunto,idDoc,idCli,tipo);
                    }
                })
            }
            else {
                EstructuraEnvio(para,de,asunto,idDoc,idCli,tipo);
            }
        }
        else if (para == 0) {
            swal("¡Espera!", "Ingresa al destinatario", "warning");
        }
        else if (de == 0) {
            swal("¡Espera!", "Ingresa al remitente", "warning");
        }
    }

    function EstructuraEnvio(para,de,asunto,idDoc,idCli,tipo) {
        const archivos = document.getElementById('AddFiles').value;
        var cuerpo = "";
        var upload = "";

        if (tipo == 1) {
            const textCorreo = document.getElementById('TextBodyEmail').innerHTML;

            if (textCorreo != 0) {
                cuerpo = textCorreo;
                $('#FormBtnSend').click();
                
                /*$.ajax({
                    type: "POST",
                    url: `${baseUrl}/EnviarCorreo`,
                    data: {
                        e1: de,
                        e2: para,
                        sj: asunto,
                        bd: cuerpo,
                        dc: idDoc,
                        cl: idCli,
                        ul: upload
                    },
                    beforeSend: (load) => {
                    },
                    success: (data) => {
                        //const res = JSON.parse(data);
                        console.log(data);
                        //if (res == "Enviado") {
                        //    swal("¡Enviado!", "Correo envido exitósamente.", "success");
                        //}
                        //else if (res == "Error") {
                        //    swal("¡Uups!", "Hay problemas al intentar enviar el correo.", "error");
                        //}
                    },
                    error: (error) => {
                        swal("¡Uups!", "Hay problemas al intentar enviar el correo.", "error");
                    }
                })*/
            } 
            else {
                swal("¡Espera!", "No has escrito tu mensaje", "warning");
            }
        }
        else if (tipo == 2) {
            const plantilla1 = document.getElementById('TextBodyEmail').innerHTML;
            const nombre = document.getElementById('eNameClient').innerHTML;
            const poliza = document.getElementById('eNumeroPoliza').innerHTML;
            const compania = document.getElementById('eCompania').innerHTML;
            const vigencia = document.getElementById('eVigencia').innerHTML;
            const formapago = document.getElementById('eFormaPago').innerHTML;
            const primatotaldoc = document.getElementById('ePrimaTotal').innerHTML;
            const primerrecibo = document.getElementById('ePrimerRecibo').innerHTML;
            const limitepago = document.getElementById('eFechaLimitePago').innerHTML;
            const primarenovacion = document.getElementById('ePrimaRenovacion').innerHTML;
            const primavigencia = document.getElementById('ePrimaVigenciaAnterior').innerHTML;
            const porcentaje = document.getElementById('ePorcIncrRenov').innerHTML;
                
            console.log("Cliente: "+nombre+", Poliza: "+poliza+", Compañía: "+compania+", Vigencia: "+vigencia+", FormaPago: "+formapago+", PrimaTotal: "+primatotaldoc+", PrimerRecibo: "+primerrecibo+", LimitePago: "+limitepago+", Renovación: "+primarenovacion+", PrimaVigenciaAnterior: "+primavigencia+", Porcentaje: "+porcentaje);

            //if (nombre == 0 || poliza == 0 || compania == 0 || vigencia == 0 || formapago == 0 || primatotaldoc == null || primerrecibo == null || limitepago == 0 || primarenovacion == null || primavigencia == null || porcentaje == null) {
            //    swal("¡Un momento!", "Parece que falta información en su documento.", "warning");
            //}
            //else {
                cuerpo = plantilla1;
                $('#FormBtnSend').click();

                /*$.ajax({
                    type: "POST",
                    url: `${baseUrl}/EnviarCorreo`,
                    data: {
                        e1: de,
                        e2: para,
                        sj: asunto,
                        bd: cuerpo,
                        dc: idDoc,
                        cl: idCli
                    },
                    beforeSend: (load) => {
                    },
                    success: (data) => {
                        const res = JSON.parse(data);
                        console.log(res);
                        if (res == "Enviado") {
                            swal("¡Enviado!", "Correo envido exitósamente.", "success");
                        }
                        else if (res == "Error") {
                            swal("¡Uups!", "Hay problemas al intentar enviar el correo.", "error");
                        }
                    },
                    error: (error) => {
                        swal("¡Uups!", "Hay problemas al intentar enviar el correo.", "error");
                    }
                })*/
            //}
        }
    }

    function IconType(i) {
        const type = i;
        var icon = "";

        if (type == "application/pdf") {
            icon = "fa-file-pdf-o icon-pdf";
        }
        else if (type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            icon = "fa-file-word-o icon-word";
        }
        else if (type == "application/vnd.ms-excel") {
            icon = "fa-file-excel-o icon-excel";
        }
        else if (type == "text/xml" || type == "text/plain" || type == "text/css") {
            icon = "fa-file-text-o icon-text";
        }
        else if (type == "text/calendar") {
            icon = "fa-calendar-o icon-text";
        }
        else if (type == "image/png" || type == "image/jpeg" || type == "image/webp") {
            icon = "fa-file-image-o icon-img";
        }
        else if (type == "application/x-zip-compressed") {
            icon = "fa-file-archive-o icon-comp";
        }
        else if (type == "") {
            icon = "fa-file-o icon-in";
        }
        return icon;
    }

    function SizeType(t) {
        const size = t;
        var type = "";
        var mb = "";

        if (size.length <= 3) {
            type = size + " KB";
        }
        else if (size.length >= 4 && size.length <= 6) {
            mb = (size / 1024).toFixed(1);
            type = mb + " MB";
        }
        return type;
    }

    <?
      function ImprimirCorreos($datos){
        $option="";  
        foreach ($datos as $key1 => $value1) {
            $option.='<optgroup label="'.$value1['Name'].'" style="font-size: 12.5px">';
            foreach ($value1['Data'] as $key => $value) {
              $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
              $option.='<option class="dropdown-item" data-name="'.$nombres.'" data-email="'.$value['email'].'" onclick="SelectEmailR(this)">'.$nombres.' <label>     ('.$value['email'].')</label></option>';  
            }
            $option.='</optgroup>';
        }
        return $option;
      }
    ?>
</script>