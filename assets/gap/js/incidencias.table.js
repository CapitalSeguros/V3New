$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");
    const $IdNotificacion = $("#N").attr("data-IdNotificacion");
    const incidencia = new Incidencias({
        classRender: '.js-incidencias',
        actionOpen: '.openModal',
        reference: 'INCIDENCIAS',
        callbackSuccess: function (response) {
            datatable.ajax.reload();
            // datatable.draw();
        }
    });
    incidencia.init();

    /*const preview = new FilePreview({ //Descativado [Suemy][2024-05-31]
        classRender: ".js-preview",
        site: $path
    });
    preview.init();*/

     window.itemsI = function() {
            var acum = "";
            _TipoI .forEach(element => {
                acum += `<option value='${element.nombre}'>${element.nombre}</option>`;
            });
            return acum;
    };

    //scripts de la tabla incidencias
    const datatable = $('#example').DataTable({ //Modificado [Suemy][2024-05-31]
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}incidencias/getIncidencias`,
            type: 'GET',
            dataSrc: function (json) {
                //console.log(json.data);
                return json.data;
            }
        },
        ordering: false,
        // searching: false,
        dom: '<"toolbar">rtip ',
        initComplete: function () {
            var tmp = `<div class="row">
                <div class="col-sm-3">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
                
                <div class="col-sm-2">
                    <label>Estado </label>
                    <select class="form-control input-sm"  id="cbEstado" name="6">
                        <option value="">Todos</option>
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="AUTORIZADO">AUTORIZADO</option>
                        <option value="RECHAZADO">RECHAZADO</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Tipo </label>
                    <select class="form-control input-sm"  id="cbTipo" name="1">
                        <option value="">Todos</option>
                        ${itemsI()}
                    </select>
                </div>
            </div>`
            $('div.toolbar').html(tmp);

        },
        columns: [{
                data: 'id'
            }, {
                data: 'nombre'
            },
            {
                data: 'fecha_inicio',
                //className: "text-center",
                render: function (data, type, row) {
                    //console.log(data, type, row);
                    return moment(data).format('DD/MM/YYYY');
                }
            },
            {
                data: 'dias',
                //className: "text-center"
            },
            {
                data: 'name_complete'
            },
            {
                data: 'fecha_registro',
                render: function (data, type, row) {
                    return getDateFormat(data,1);
                }
            },
            /*{
                data: 'fecha_modificado',
                render: function (data, type, row) {
                    return getDateFormat(data,1);
                }
            },*/
            {
                data: 'estatus',
                render: function (data, type, row) {
                    return getClassByStatus(data);
                }
            },
            {
                data: null,
                "sClass": "control text-right",
                "sDefaultContent": '',
                width: '40px',
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                                <li><a style="cursor: pointer;" class="" onclick="getInfoIncidencia(${row.id})" >Ver</a></li>
                                <li><a style="cursor: pointer;" onclick="getDataHistorial(${row.id})" class="" >Seguimiento</a></li>
                                ${(row.estatus == "ACTIVO" ? `<li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="editarIncidencia(${row.id})" >Editar</a></li>` : "")}
                            </ul>
                        </div>
                    `;
                }
            }
        ],
        order: [
            [1, 'desc']
        ]
    });

    if ($IdNotificacion !== '') {
        setTimeout(function () {
            datatable.column(0).search($IdNotificacion).draw();
        }, 1000);

    }
    //evento del select del estado
    $(document).on('input', '#cbEstado', function (e) {
        datatable
            .column(e.currentTarget.name)
            .search(e.currentTarget.value)
            .draw();
    });

    //evento del select del tipo de incidencias
    $(document).on('input', '#cbTipo', function (e) {
        datatable
            .column(e.currentTarget.name)
            .search(e.currentTarget.value)
            .draw();
    });

    window.reProcesar = function (e) {
        e.preventDefault();
        $.ajax({
            url: `${$path}incidencias/re_procesar`,
            type: 'GET',
            success: function (response) {
                datatable.ajax.reload();
            }
        })
    }

    $(document).on('input', '#txSearch', function (e) {
        datatable
            .search(e.currentTarget.value)
            .draw();
    });

    /*window.jQuery(document).on('click', '.js-preview-item', function (e) { //Desactivado [Suemy][2024-05-31]
        e.preventDefault()
        preview.show(e.currentTarget.href, e.currentTarget.innerHTML);
    });*/

    window.editarIncidencia = function (id) {
        const _data = datatable.rows().data();
        const oInci = _.find(_data, function (it) {
            return it.id == id;
        })
        // oInci.fecha_inicio = moment(oInci.fecha_inicio).format('DD/MM/YYYY');
        incidencia.edit(oInci);
    }
    //script de la pagina
    ///eventos de la tabla para la validación de las incidencias;
    window.getInfoIncidencia = function (id) { //Modificado [Suemy][2024-05-31]
        $.ajax({
            type: 'GET',
            url: `${$path}incidencias/datosInicidencia`,
            data: {
                'id': id
            },
            success: function (response) {
                if (response.code == "200") {
                    //console.log(response.data);
                    cleanhtml();
                    const incidencia = response.data.incidencia;
                    $('div[id=nombre]').append(incidencia.name_complete);
                    $('div[id=comentario]').append(incidencia.comentario);
                    $('div[id=inicio]').append(moment(incidencia.fecha_inicio).format("DD/MM/YYYY"));
                    $('div[id=dias]').append(incidencia.dias);
                    $('div[id=tipo]').append(incidencia.nombre);
                    $('div[id=subida]').append(moment(incidencia.fecha_alta).format("DD/MM/YYYY"));
                    $('div[id=documentos]').append(documentsList(response.data.documento));
                    $('input[id=id_incidencia]').val(incidencia.idincidencias);
                    $('input[id=id_justificado]').val(incidencia.justificado);
                    if (incidencia.estatus == "AUTORIZADO" || incidencia.estatus == "RECHAZADO") {
                        $('div[id=respuestaContenido]').hide();
                        $('#f_respuesta').text(getDateFormat(incidencia.fecha_autorizacion,3));
                        $('#c_respuesta').text(incidencia.comentario_rechazo);
                        $('#s_incidencia').html(getIconByStatus(incidencia.estatus));
                        $('#respuestaIncidencia').show();
                    } else {
                        $('button[id=enviar]').show();
                        $('div[id=respuestaContenido]').show();
                        $('#respuestaIncidencia').hide();
                    }
                    $('textarea[id=comentario]').val('');
                    $('select[id=accion]').val('');

                    $('#mymodal').modal('show');
                }
            },
            error: function (xhr) {
                console.log('error', xhr);
            }
        });
    }

    //limpia el modal de las consultas anteriores
    function cleanhtml() {
        $('div[id=nombre]').empty();
        $('div[id=comentario]').empty();
        $('div[id=inicio]').empty();
        $('div[id=dias]').empty();
        $('div[id=tipo]').empty();
        $('div[id=subida]').empty();
        $('div[id=documentos]').empty();
    }

    //obtine los documentos de la incidencia
    function documentsList(data) { //Modificado [Suemy][2024-05-31]
        let contenido = "";
        let res = "";
        $.each(data, function (key, value) {
            const url = value.ruta_completa;
            //contenido += "<a href='" + value.ruta_completa + "' class='js-preview-item' >" + value.nombre_completo + "</a></br>";
            contenido += `
                <div class="col-md-12 pd-left pd-right pd-items-table">
                    <button class="btn-file" onclick="setVisorFile('${url}','${value.nombre_completo}')">${value.nombre_completo}</button>
                    <a class="btn btn-download" href="${url}" title="Descargar" target="_blank" role="menuitem" tabindex="-1" data-target="#" download><i class="fas fa-cloud-download-alt"></i></a>
                </div>
            `;
        });
        return contenido;
    }

    function recharge() {
        location.reload();
    }
    //valida el form de validación de la incidencia
    window.ValidaciondeIncidencia = function () { //Modificado [Suemy][2024-05-31]
        let comentario = $('textarea[id=descripcion]').val();
        let idincidencia = $('input[id=id_incidencia]').val();
        let accion = $('select[id=accion]').val();
        const justificado = $('input[id=id_justificado]').val();
        if (accion == 2 && comentario == '') {
            toastr.error("Es necesario un comentario en un Rechazo.");
            return;
        }
        if (justificado == 0) {
            swal({
                title: "¿Está seguro de querer continuar?",
                text: "La incidencia esta sin justificar con algún documento.",
                icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: true,
                },
            }).then((value) => {
                if (value) {
                    if (accion == 2 && comentario != '') {
                        ajaxValidacionIncidencia(comentario, idincidencia, accion);
                    }

                    if (accion == '1') {
                        ajaxValidacionIncidencia(comentario, idincidencia, accion);
                    }
                }
            });
            return;
        }
        if (accion == 2 && comentario != '') {
            ajaxValidacionIncidencia(comentario, idincidencia, accion);
        }

        if (accion == '1') {
            ajaxValidacionIncidencia(comentario, idincidencia, accion);
        }

    }

    $('select[id=accion]').on('change', function () {
        $('button[id=enviar]').removeAttr("disabled");
        //$('textarea[id=enviar]').removeAttr("disabled");
    });

    window.getDataHistorial = function (id) {
        $.ajax({
            url: `${$path}seguimiento/get/`,
            data: {
                id: id,
                referencia: 'INCIDENCIA'
            },
            method: 'GET',
            dateType: 'json',
            success: function (response) {
                window.modalModalSeguimiento.show("Seguimiento de incidencias", response.data)
            }
        });

    }

    function ajaxValidacionIncidencia(comentario, idincidencia, accion) {
        $.ajax({
            type: 'POST',
            url: `${$path}incidencias/gestionIncidencia`,
            data: {
                'comentario': comentario,
                'id': idincidencia,
                'accion': accion
            },
            beforeSend: function () {
                $('label[id=status]').append("Procesando, espere por favor...");
            },
            success: function (data) {
                //$('div[id=status]').show();
                var json = JSON.parse(data);
                $('div[id=danger]').addClass('hidden');
                $('button[id=enviar]').hide();
                window.toastr.success(json.mensaje);
                datatable.ajax.reload();
                $('#mymodal').modal('hide');

            },
            error: function (xhr) {
                console.log('error', xhr);
            }
        });

    }
    
    contador("#descripcion","#caracteres");
});

    function getClassByStatus(status) { //Creado [Suemy][2024-05-31]
        var clase = "";
        var text = "";
        switch (status) {
            case "ACTIVO" : clase = "primary"; text = "Activo"; break;
            case "AUTORIZADO": clase = "success"; text = "Autorizado"; break;
            case "RECHAZADO": clase = "danger"; text = "Rechazado"; break;
            case "CANCELADO": clase = "warning"; text = "Cancelado"; break;
        }
        return `<span class="label label-${clase}">${text}</span>`;
    }

    function getIconByStatus(status) { //Creado [Suemy][2024-05-31]
        var clase = "";
        var icon = "";
        switch (status) {
            case "ACTIVO" : clase = "primary"; text = `<i class="fas fa-clipboard-list"></i> Activo`; break;
            case "AUTORIZADO": clase = "success"; text = `<i class="fas fa-check-circle"></i> Autorizado`; break;
            case "RECHAZADO": clase = "danger"; text = `<i class="fas fa-times-circle"></i> Rechazado`; break;
            case "CANCELADO": clase = "warning"; text = `<i class="fas fa-exclamation-circle"></i> Cancelado`; break;
        }
        return `<span class="label label-${clase}">${text}</span>`;
    }

    function setVisorFile(url,file){ //Creado [Suemy][2024-05-31]
        $('#NameDocument').text('('+file+')');
        const iframe = document.getElementById('visor');
        let ref = url.slice((url.lastIndexOf(".") - 1 >>> 0) + 2);
        ref = ref.toUpperCase();
        if(ref=='XLS' || ref=='XLSX' || ref=='DOC' || ref=='DOCX' || ref=='XLSM' || ref=='PPTX') {
          iframe.innerHTML = `<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=${url}' width='100%' height='100%' frameborder='0'></iframe>`;
        }
        else if(ref=='XML' || ref=='TXT' || ref=='JPG' || ref=='PNG' || ref=='JPEG') {
          iframe.innerHTML = `<iframe src="${url}"  width="100%" height="100%" class="container-xml"></iframe>`;
        }
        else if(ref=='PDF') {
          iframe.innerHTML = `<iframe src="${url}" style="width: 100%;border-style: none;height: -webkit-fill-available;"></iframe>`;
        }
        else if (ref=='MP4') {
          iframe.innerHTML = `<video controls="" autoplay="" name="media" style="width: -webkit-fill-available;height: -webkit-fill-available;"><source src="${url}" type="video/mp4"></video>`;
        }

        $("#visor_file").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

    function contador(textarea, caracteres){
        function update_contador(textarea, caracteres){
            var contador = $(caracteres);
            var ta = $(textarea);   
            contador.html(ta.val().length);
        }
        $(textarea).keyup(function(){
            update_contador(textarea,caracteres);
        });
        $(textarea).change(function(){
            update_contador(textarea,caracteres);
        });
    }

    function getDateFormat(data,format) { //Creado [Suemy][2024-05-31]
        let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            if (!data.includes(':')) { data = data + " 00:00:00";}
            date = new Date(data);
            switch (format) {
                case 1:
                    dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 2:
                    dateF = numberday[date.getDate()] + "/" + monthname[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 3:
                    dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
                break;
            }
        }
        return dateF;
    }