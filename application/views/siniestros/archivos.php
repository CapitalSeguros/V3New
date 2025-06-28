<?
    //var_dump($employee);
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<style type="text/css">
  	
  	/*ID*/
  		#contTableExport {height: 350px;overflow: auto;border-bottom: 1px solid #dbdbdb;background: #f7f7f7;padding: 0px;}
        #TableDocumentSiniestro thead > tr > th:nth-child(5), #TableDocumentSiniestro thead > tr > th:nth-child(9) {min-width: 200px;}
    /*Containers*/
        .container-table > table {height: 100%; margin: 0px;}
    /*Others*/
        .show {visibility: visible;}
  	/*Checkbox | Radio*/
    	.form-check-input {
    	  	width: 23px;
    	  	height: 23px;
    	}
    /*Media Query*/
        @media (min-width: 1281px) {
            .container-table-bootstrap { max-width: 1162px; }
        }
        @media (max-width: 1280px) {
            .segment-options { max-width: 55%; }
            /*.container-table { max-width: 1000px;/*1030*/ }*/
            .container-table-bootstrap { max-width: 1000px; } /*1031*/
        }
        @media (max-width: 1024px) {
            .segment-options { max-width: 40%; }
            .container-table { max-width: 745px;/*770*/ }
        }
        @media (max-width: 800px) {
            .segment-options { max-width: 30%; }
            .container-table { max-width: 550px; }
        }
</style>
<div class="col-md-12">
    <section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="title-Polizas">Subir Archivos Siniestros</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7"></div>
        </div>
        <hr/>
    </section>
    <div class="col-md-12" style="margin-bottom: 80px;">
        <div class="panel panel-default">        
            <div class="panel-body">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="col-md-12 column-flex-center-start pd-left pd-right">
                        <h5 class="titleSection mg-top-cero"><i class="fas fa-upload"></i> Subir Documentos
                            <button class="btn-view-cont" data-toggle="collapse" href="#segAlertInfo" aria-expanded="true">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </h5>
                    </div>
                    <div class="col-md-12 pd-left pd-right"><hr class="title-hr"></div>
                    <div class="col-md-12">
                        <div class="col-md-12 collapse pd-bottom" id="segAlertInfo">
                            <div class="alert alert-primary" role="alert" style="margin: 0px;">
                                <h4 style="font-size: 16px;"><i class="fas fa-exclamation-circle"></i> Información</h4>
                                <p style="font-size: 14px;">En este apartado podrás guardar los documentos relacionados son los Siniestros y no solo necesariamente para encuestas. En la tabla de abajo se mostrarán todos los archivos que subas en este módulo.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 container-form" id="documentRegister" style="margin-bottom: 40px;">
                        <div class="container-spinner" id="spinnerUpload" style="position: relative;"></div>
                        <form action="<?=base_url()?>siniestros/subirEncuesta" id="FormUploadDocument" enctype="multipart/form-data" method="post">
                            <div class="col-md-12 pd-items-table">
                                <div class="col-md-6 pd-left">
                                    <label class="textForm">Nombre Documento:</label>
                                    <input type="text" class="form-control register" name="nameD" id="nameDocument" title="Nombre Documento"><br>
                                    <label class="textForm">Supervisado por:</label>
                                    <select class="form-control register" id="nameUser" title="Nombre"><?=printEmployees($employees,$idPersona);?></select><br>
                                    <label class="textForm">Tipo Documento:</label>
                                    <select class="form-control register" name="typeD" id="typeDocument" title="Tipo Documento">
                                        <option value="1">Ninguno</option>
                                        <option value="encuesta" selected>Encuesta</option>
                                    </select><br>
                                    <label class="textForm">Descripción:</label>
                                    <textarea type="text" class="form-control register" name="descD" id="description" title="Descripción" placeholder="Puedes escribir detalles sobre este documento (opcional)" maxlength="400" style="height: 61px;"></textarea>
                                    <label class="caracter-label mg-cero">
                                        Caracteres ingresados: <span id="caracteres">0</span> de 400
                                    </label>
                                </div>
                                <div class="col-md-6 pd-right">
                                    <label class="textForm">Ramo:</label>
                                    <select class="form-control register" name="ramoD" id="ramoDocument" title="Ramo" onchange="selectRamo(this,'folderDocument')"><?=$selectF?></select><br>
                                    <label class="textForm">Fecha Documento:</label>
                                    <input type="date" class="form-control register" name="dateD" id="dateDocument" title="Fecha Documento" value="<?=date('Y-m-d')?>"><br>
                                    <label class="textForm">Guardar en (Carpeta):</label>
                                    <select class="form-control register" name="folderD" id="folderDocument" title="Guardar en (Carpeta)" onchange="selectRamo(this,'ramoDocument')"><?=$selectF?></select><br>
                                    <label class="textForm">Seleccionar Documento:</label>
                                    <input class="form-control register" type="file" name="fileD" id="fileD" title="Seleccionar Documento">
                                    <input class="form-control" type="hidden" name="person" id="person" title="Tipo Persona" value="<?=$typeUser?>">
                                </div>
                            </div>
                            <div class="col-md-12 column-flex-center-end">
                                <button type="submit" class="btn btn-primary" id="btnRegister">
                                    <i class="fas fa-save"></i> Guardar
                                </button> <!-- type="submit" -->
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 column-flex-center-start pd-left pd-right">
                        <h5 class="titleSection mg-top-cero"><i class="fas fa-folder-open"></i> Documentos Registrados</h5>
                    </div>
                    <div class="col-md-12 pd-left pd-right"><hr class="title-hr"></div>
                    <div class="col-md-12 pd-items-table column-flex-center-end">
                        <input type="text" class="form-control" placeholder="Filtrar" id="filterTable" style="width: 30%;">
                    </div>
                    <div class="col-md-12" style="margin-bottom: 40px;">
                        <div class="container-table">
                            <table class="table table-striped" id="TableDocumentSiniestro">
                                <thead class="table-thead">
                                    <tr class="table-tr">
                                        <th>Título</th>
                                        <th>Tipo Documento</th>
                                        <th>Ramo</th>
                                        <th>Fecha Documento</th>
                                        <th>Descripción</th>
                                        <? if ($permission > 0) { ?>
                                        <th>Nombre Archivo</th>
                                        <? } ?>
                                        <th>Registrado Por</th>
                                        <? if ($permission > 0) { ?>
                                        <th>Tipo Persona</th>
                                        <? } ?>
                                        <th>Registro</th>
                                        <th>Descargar</th>
                                        <? if ($permission > 0) { ?>
                                        <th>Eliminar</th>
                                        <? } ?>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableDocumentSiniestro"></tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- Spinner Bar -->
<div id="loading-bar" class="container-spinner-bar hidden">
    <div class="container-spinner-bar-content-loading">
        <div class= "spinner-bar">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>       
</div>

<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        getTableDocumentSiniestro();
        counter("#description","#caracteres");

        $('#filterTable').keyup(function() {
            const val = this.value.toUpperCase();
            filterTable(val,'bodyTableDocumentSiniestro','show-register');
        })

        $("#FormUploadDocument").on('submit', function(e) {
            e.preventDefault();
            var verify = verifyDataDocument();
            if (verify == true) {
                var formData = new FormData(document.getElementById("FormUploadDocument"));
                $.ajax({
                    url: `<?=base_url()?>siniestros/uploadSurvey`,
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: (load) => {
                        $('#spinnerUpload').css('position','');
                        $('#spinnerUpload').html(`
                            <div class="container-spinner-content-loading">
                                <div class="cr-spinner spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="cr-cargando" style="font-size:18px;">Enviando...</p>
                            </div>
                        `);
                    },
                    success: (data) => {
                        const r = JSON.parse(data);
                        console.log(r);
                        $('#spinnerUpload').css('position','relative');
                        $('#spinnerUpload').html("");
                        if (r['status'] == "success") {
                            swal("¡Guardado!", "El documento se guardó exitósamente.", "success");
                            getTableDocumentSiniestro();
                        }
                        else if (r['status'] == "exists") {
                            swal("¡Espera!", "Ya existe un documento con ese nombre y ese formato.", "warning");
                        }
                        else {
                            swal("¡Vaya!", "Ocurrió un confilcto al guardar el documento.", "error");
                        }
                    },
                    error: (error) => {
                        console.log(error);
                        $('#spinnerUpload').css('position','relative');
                        $('#spinnerUpload').html("");
                        swal("¡Uups!", "Hay problemas al intentar guardar.", "error");
                    }            
                })
            }
        })
    })

    const permission = (`<?=$permission?>` != 0) ? 1 : 0;
    const baseUrl = '<?=base_url()?>siniestros';

    function verifyDataDocument() {        
        let form = document.getElementById('documentRegister');
        let input = form.getElementsByClassName('register');
        let values = [];
        var empty = "";
        //console.log(input);
        for (let i=0;i<input.length;i++) {
            if (input[i].value != 0 || input[i].id == "description") {
                values.push(input[i].value);
                //console.log(values[values.length - 1]);
            }
            else {
                if (empty != 0) { empty = empty + ", "; }
                empty = empty + input[i].title;
            }
        }
        console.log(empty);
        if (empty != 0) {
            return swal("¡Espera!", "Los siguientes campos están vacíos: " + empty + ".", "warning"); 
        }
        else {
            console.log(values);
            return true;
        }
    }

    function getTableDocumentSiniestro() {
        const cell = (permission == 1) ? 11 : 8;
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getDocumentsSiniestros`,
            beforeSend: (load) => {
                $('#bodyTableDocumentSiniestro').html(`
                    <tr>
                        <td colspan="${cell}">
                            <div class="container-spinner-content-loading">
                                <div class="cr-spinner spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                let d = r['documents'];
                var trtd = ``;
                if (d != 0) {
                  for (const a in d) {
                    const responsible = `<label class="text-author-comment mg-cero">${d[a].name_complete} (${d[a].email})</label>`;
                    const person = (d[a].tipoPersona == 1) ? "Colaborador" : "Agente";
                    const url = `<?=base_url()?>archivosSiniestros` + d[a].url + '/' + d[a].archivo;
                    var ramo = getTextValue(d[a].ramo);
                    ramo = (ramo != "") ? ramo.toUpperCase() : "Ninguno";
                    ramo = (ramo == "DANIOS") ? "DAÑOS" : ramo;
                    trtd += `
                      <tr class="show-register" data-id="${d[a].id}">
                        <td>${d[a].titulo}</td>
                        <td>${getTextValue(d[a].tipo_documento)}</td>
                        <td>${ramo}</td>
                        <td>${getDateFormat(d[a].fecha,2)}</td>
                        <td>${d[a].descripcion}</td>
                        <? if ($permission > 0) { ?>
                        <td>${d[a].archivo}</td>
                        <? } ?>
                        <td>${responsible}</td>
                        <? if ($permission > 0) { ?>
                        <td>${person}</td>
                        <? } ?>
                        <td>${getDateFormat(d[a].registro,5)}</td>
                        <td><a class="btn btn-primary" href="${url}" target="_blank" download>Descargar <i class="fas fa-download"></i></a></td>
                        <? if ($permission > 0) { ?>
                        <td><button class="btn btn-danger" id="btnDelete${d[a].id}" onclick="deleteDocumentSiniestro(${d[a].id})" style="width:86px;">Eliminar <i class="fas fa-trash"></i></button></td>
                        <? } ?>
                      </tr>
                    `;
                  }
                }
                else {
                    trtd = `<tr><td colspan="${cell}"><center><strong>Sin resultados</strong><center></td></tr>`;
                }

                $('#bodyTableDocumentSiniestro').html(trtd);
            },
            error: (error) => {
              console.log(error);
            }
        })
    }

    function deleteDocumentSiniestro(id) {
        swal({
            title: "¿Desea eliminarlo?",
            text: "Este documento se eliminará permanentemente.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: "POST",
                    url: `${baseUrl}/deleteSurvey`,
                    data: { id: id, },
                    beforeSend: (load) => {
                        $('#btnDelete'+id).html(`
                            <div class="container-spinner-btn-loading">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                            </div>
                        `);
                    },
                    success: (data) => {
                        const r = JSON.parse(data);
                        console.log(r);
                        if (r['status'] == true) {
                            swal("¡Hecho!", "El documento ha sido eliminado.", "success");
                            getTableDocumentSiniestro();
                        }
                        else {
                            swal("¡Vaya!", "Ocurrió un confilcto al eliminar el documento.", "error");
                        }
                    },
                    error: (error) => {
                        console.log(error);
                        $('#btnDelete'+id).html(`Eliminar <i class="fas fa-trash"></i>`);
                        swal("¡Uups!", "Ocurrió un error al intentar la acción.", "error");
                    }
                })
            }
        })
    }

    //------------------------------- OPERACIONES -----------------------------------
    function selectRamo(obj,select) {
        var folder = obj.value;
        $('#'+select+' option[value="'+folder+'"]').prop('selected',true);
    }

    function counter(textarea, caracteres){
        function update_counter(textarea, caracteres){
            var counter = $(caracteres);
            var ta = $(textarea);   
            counter.html(ta.val().length);
        }
        $(textarea).keyup(function(){
            update_counter(textarea,caracteres);
        });
        $(textarea).change(function(){
            update_counter(textarea,caracteres);
        });
    }

    function filterTable(value,body,clase) {
        var filter, panel, d, td, i, j, k, visible;
        var tr = "";
        filter = value;
        panel = document.getElementById(body);
        d = panel.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName(clase);
        //
        for (i = 0; i < d.length; i++) {
            visible = false;
            td = d[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                d[i].style.display = "";
                $(d[i]).addClass(clase);
            }
            else {
                d[i].style.display = "none";
                $(d[i]).removeClass(clase);
            }
        }
        result = Fila.length;
    }

    function iconFunction(event,type) {
        const icon = $(event).children('i');
        if (type == 1) {
            icon.attr('class', icon.hasClass('fas fa-arrow-circle-left') ? 'fas fa-arrow-circle-right' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fas fa-arrow-circle-left') ? 'Mostrar Menú' : 'Ocultar Menú');
        }
        else if (type == 2) {
            icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
        }
        else if (type == 3) {
            icon.attr('class', icon.hasClass('fa fa-info-circle') ? 'fas fa-info' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-info-circle') ? 'Ver Info' : 'Ocultar Info');
        }
    }

    function orderArray(array) {
        let compare;
        compare = function(a,b) {
            return (b.comision - a.comision);
        };
        array.sort(compare);
        return array;
    }

    function getNumberValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "" || data == 0) {
            data = 0;
        }
        return data;
    }

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

    function getDateFormat(data,format) { //Formato definitivo -> Checar el modelo de este módulo para que funcione
        let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
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
            if (format == 1) {
                dateF = date.getDate() + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 2) {
                dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 3) {
                //fecha.replace(/[-]/g, "/"); //Reemplaza todas "-" por "/"
                dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
            }
            else if (format == 4) {
                dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
            }
            else if (format == 5) {
                dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
            }
            else if (format == 6) {
                dateF = monthname[date.getMonth()];
            }
        }
        return dateF;
    }

    <?
        function printEmployees($data,$idPersona){
            $option = "<option value='0'>Seleccione un correo</option>";
            foreach ($data as $key => $val) {
                $option.='<optgroup data-filter="'.$key.'" label="'.$key.'">';
                foreach ($val as  $value) {
                    if ($value->idPersona != "0" || $value->idPersona != 0 || !empty($value->idPersona) || $value->idPersona != NULL) {
                        $selected = "";
                        if ($idPersona == $value->idPersona) { $selected = "selected"; }
                        if (!empty($value->personaPuesto)) {
                            $job = '<label style="color:black;">'.$value->personaPuesto.'</label>, ';
                        }
                        $text = $value->apellidoPaterno.' '.$value->apellidoMaterno.' ';
                        $text.= $value->nombres.' ('.$job.$value->email.')';
                        $option.= '<option class="dropdown-item" data-filter="'.$key.'" value="'.$value->idPersona.'" '.$selected.'>'.$text.'</option>';
                    }
                }
                $option.='</optgroup>';
            }
            return $option;
        }
    ?>
</script>
<!--

-->