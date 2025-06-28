<div class="col-md-12 bg-table tab-pane hidden" id="PanelP6" style="padding: 0px; margin-bottom: 0px;">
    <div class="col-md-12 content-detalles">
        <div class="segment-p-detalles">
            <div class="modal-header segment-header-detalles">
                <h4 class="title-result" id="TitleAddFile">Agregar archivos</h4> <!-- ?servidor -->
            </div>
            <div class="content-send-email" id="TabP6-Spinner"></div>
            <div class="modal-body segment-body-detalles" style="height: 480px;">
                <div class="col-md-12 content-info-detalles" id="MensajeAyuda" style="display: none;">
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" id="CerrarAlertaP6" title="Ocultar" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><i class="fa fa-info-circle"></i>&nbsp;Consideraciones</h5>
                        <ul style="text-align: initial;">
                            <li>
                                <p>El panel <strong>Agregar Archivos</strong> aparecerá cuando se busque por <strong>Documento</strong> o por <strong>Cliente</strong>.</p>
                            </li>
                            <li>
                                <p>Cuando se hayan guardado los archivos se podrá visualizar en el Centro Digital.</p>
                            </li>
                            <li>
                                <p>La <strong>Descripción</strong> tiene un límite de 20 caracteres.</p>
                            </li>
                            <li>
                                <p>En el <strong>Tipo Documento</strong> los de color <span class="square-document"></span> van dirigidos al documento, mientras que los de color <span class="square-client"></span> es para el cliente. Por lo tanto, se guardarán en la respectiva carpeta dependiendo del tipo seleccionado.</p>
                            </li>
                            <li>
                                <p>La búsqueda por <strong>Documento</strong> es la única que puede guardar archivos para <span style="font-style: italic;">Documento</span> o para <span style="font-style: italic;">Cliente</span>.</p>
                            </li>
                            <li>
                                <p>El <strong>Tipo Documento</strong> y la <strong>Descripción</strong> son obligatorios debido a que estos conforman el nuevo nombre del archivo seguido de la fecha y hora que se guarde. Por ejemplo, si se selecciona "ENDOSO", se describe "ARCHIVO" y se guarda el 13 de Junio del 2023 a las 2:52 p.m. el resultado será "ENDOSO-ARCHIVO-202306131452".</p>
                            </li>
                            <li>
                                <p>La opción <span style="font-style: italic;">SIN TIPO</span> del <strong>Tipo Documento</strong> es para escribir el nombre del archivo sin una etiqueta con la respectiva fecha y hora, es decir, si se usa esta opción y en <strong>Descripción</strong> se escribe "acta documento" el nombre del archivo será "ACTA_DOCUMENTO-202306131452".</p>
                            </li>
                            <li>
                                <p>El nombre del archivo en el Centro Digital siempre estará en mayúsculas sin importar que en la <strong>Descripción</strong> se haya escrito con minúsculas.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 segment-header-recibos space-bottom-r">
                    <div class="col-md-6 column-flex-center">
                        <span class="title-item-consult" style="margin-right: 5px;">Dirigido al:</span>
                        <div class="col-md-4" style="max-width: max-content;padding-left: 0px;">
                            <span class="circle-client">o</span>
                            <span class="title-item-consult">Cliente</span>
                        </div>
                        <div class="col-md-5" style="max-width: max-content;padding-left: 0px;">
                            <span class="circle-document">o</span>
                            <span class="title-item-consult">Documento</span>
                        </div>
                    </div>
                    <div class="col-md-6 column-flex-item-end">
                        <span class="title-item-consult" style="margin-right: 5px;">Opciones:</span>
                        <button class="btn-upload-files" id="MostrarAyuda" title="Información" style="padding: 8px 14px;">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-upload-files" id="CargarArchivo" title="Seleccionar Archivos" disabled>
                            <i class="fa fa-desktop" aria-hidden="true"></i>
                        </button>
                        <input type="file" class="hidden" id="LoadFile" name="myfiles[]" multiple>
                        <button class="btn btn-upload-files" id="BorrarTodo" title="Borrar Todos Los Archivos" disabled>
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-upload-files" id="GuardarArchivo" title="Guardar Archivos" onclick="AgregarArchivos()" disabled>
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-12 container-table">
                    <div class="col-md-12" style="height:375px;overflow:auto; padding:0px;">
                        <table class="table table-striped table-recibos" id="TablaDocCliente" style="margin-bottom: 0px;">
                            <thead class="table-thead">
                                <tr class="title-sub-table" style="background: #266093;">
                                    <th colspan="1">Nombre</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody class="list-table-load-files-body" id="BodyTablaSubirArchivos"></tbody>
                        </table>
                    </div>
                    <div style="display: none"><?= MostrarTipoDocumentosDCPAGenerales($tipoImagenes);?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let formData = new FormData();
    let indexFormData = 0;

    $(document).ready(function() {
        const cargar = document.getElementById('LoadFile');
        $('#CargarArchivo').click(function() {
            cargar.click();
        })

        $(cargar).change(function() {
            let files = this.files;
            //Agregar datos adicionales
            if (files.length > 0) {
                for (const p in files) {    
                    if(typeof(files[p])!='function') {
                        if(p!='length') {
                            formData.append('files'+indexFormData,files[p]);
                            formData.append('files'+indexFormData+'select','0');
                            formData.append('files'+indexFormData+'input','');
                            indexFormData++;
                            //console.log(files[p]);
                        }
                    }
                }
                this.value = "";
                VerArchivos();
            }
            //Botón Eliminar
            if (files != null) {
                $('#BorrarTodo').prop('disabled',false);
                $('#GuardarArchivo').prop('disabled',false);
            }
            else {
                $('#BorrarTodo').prop('disabled',true);
                $('#GuardarArchivo').prop('disabled',true);
            }
        })

        $('#BorrarTodo').click(function() {
            let array=[];
            for(let [name,valor] of formData){
                array.push(name);
                //console.log(name);
            }
            array.forEach(a=>{
                formData.delete(a);
            })
            VerArchivos();
            $('#BorrarTodo').prop('disabled',true);
            $('#GuardarArchivo').prop('disabled',true);
        })

        $('#CerrarAlertaP6').click(function() {
            $('#MostrarAyuda').click();
        })

        $('#MostrarAyuda').click(function() {
            $('#MensajeAyuda').toggle(500,"easeInOutSine");
        })
    })

    function VerArchivos() {
        var trtd = ``;
        let opciones=document.getElementById('DPCAGenerales').childNodes;
        let opcionesInner='';
        for(let [name, value] of formData) {
            if(typeof(value)=='object') {
                let opcionesInner='';
                let tipo=formData.get(name+"select");
                let descripcion=formData.get(name+"input");
                for(let op of opciones){
                    if(op.value==tipo){
                        opcionesInner+=`<option value="${op.value}" selected>${op.innerHTML}</option>`;
                    }
                    else{
                        if(op.value == 5 || op.value == 7 || op.value == 11 || op.value == 12 || op.value == 21 || op.value == 22) {
                            opcionesInner+=`<option class="select-client" value="${op.value}">${op.innerHTML}</option>`;
                        }
                        else if (op.value == 23) {
                            opcionesInner+=`<option value="${op.value}">${op.innerHTML}</option>`;
                        }
                        else {
                            opcionesInner+=`<option class="select-document" value="${op.value}">${op.innerHTML}</option>`;
                        }
                    }
                }
                trtd += `
                <tr data-id="${name}">
                    <td class="text-file-exp" title="${value.name}" style="max-width: 200px;">${value.name}</td>
                    <td>
                        <select class="form-control dato1" value="${tipo}" data-val="${name}select" onchange="GuardarCambios(this)">
                            ${opcionesInner}
                        </select>
                    </td>
                    <td style="padding: 8px 0px 8px 15px;"><input type="text" class="form-control dato2" value="${descripcion}" data-val="${name}input" maxlength="20" minlegth="10" onchange="GuardarCambios(this)"></td>
                    <td><button class="btn btn-danger" data-val="${name}" onclick="EliminarArchivo(this)" style="border-radius: 5px;color: white;">Eliminar</button></td>
                </tr>`;
                console.log(name);
            }
        }
        document.getElementById('BodyTablaSubirArchivos').innerHTML = trtd;

        if (TypeSearch == 3) {
            $('.select-document').addClass('hidden');
        }
        else {
            $('.select-document').removeClass('hidden');
        }
    }

    function EliminarArchivo(file) {
        formData.delete(file.dataset.val);
        formData.delete(file.dataset.val+'select');
        formData.delete(file.dataset.val+'input');
        VerArchivos();
    }

    function GuardarCambios(file) {
        formData.set([file.dataset.val],file.value);
        //$('input[class="dato1"][data-val="'+file.dataset.val+'"]').val();
    }

    function VerificarCampos() {
        let band=true;  
        for(let [name, value] of formData) {
            if(name.includes('select')){
                if(value=='0'){band=false}
            }
            if(name.includes('input')){
                if(value==''){band=false}
            }
        }
        return band;
    }

    function AgregarArchivos() {
        formData.append('cl',D1IDCli);
        formData.append('dc',D1IDDocto);
        formData.append('doc',P1Documento);
        formData.append('tp',TypeSearch);
        console.log("IDCli: "+D1IDCli+", IDDocto: "+D1IDDocto+", Documento: "+P1Documento+", Tipo Búsqueda: "+TypeSearch);
        //Versión 1
        if (!VerificarCampos()) {
            swal("Espera", "Falta descripción o seleccionar el tipo.", "warning");
            return false;
        }
        else {
            $.ajax({
                url: `${baseUrl}/SubirArchivos`,
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: (load) => {
                    $('#TabP6-Spinner').html(`
                        <div class="container-spinner-content-tab-send-email">
                            <div class="cr-spinner spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            <p class="cr-cargando" style="font-size:18px;">Procesando...</p>
                        </div>
                    `);
                },
                success: (data) => {
                    const r = JSON.parse(data);
                    console.log(r);
                    //console.log(data);
                    $('#TabP6-Spinner').html("");
                    const resp = r['resultado'];
                    if (resp.estado == "Enviado") {
                        swal("¡Guardado!", "Los archivos se han agregado exitósamente.", "success");
                        $('#CentroDigitalCli').html(`
                            <div class="container-spinner-content-solicitudes-polizas">
                                <div class="tr-spinner spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="bd-cargando" style="font-size:18px;margin:0px;">Espere por favor.</p>
                                <p class="bd-cargando" style="font-size:18px;">Esto puede tardar unos momentos...</p>
                            </div>
                        `);

                        $('#CentroDigitalDoc').html(`
                            <div class="segment-p-centrodigital" id="CentroDigitalDoc" style="height:auto; padding-bottom:0px;">
                            </div>
                        `);
                        DocumentsCD(TypeSearch,D1IDCli,P1Documento);
                    }
                    else if (resp.estado == "Error") {
                        swal("¡Vaya!", "Ocurrió un confilcto al intentar guardar.", "error");
                    }
                },
                error: (error) => {
                    $('#TabP6-Spinner').html("");
                    swal("¡Uups!", "Ha ocurrido un problema.", "error");
                }
            })
        }
    }

    <?
        function MostrarTipoDocumentosDCPAGenerales($array){
            $select='<select id="DPCAGenerales" class="form-control"><option value="0">SELECCIONAR</option><option value="23">SIN TIPO</option>';
            foreach ($array as  $value){
                $check='';
                /*if($value->idTipoImg==18){$check='selected';}*/
                $select.='<option value="'.$value->idTipoImg.'" '.$check.'>'.$value->nombre.'</option>';
            }
            $select.='</select>';
            return $select;
        }
    ?>
</script>