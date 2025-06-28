<?
    //var_dump($ramos);
	//echo $idPersona;
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-table-style.css">
<style type="text/css">
	/*ID*/
        #BtnMenuEncuestaS.active {margin-left: -125px;}
        #PanelBotonesEncuestaS td {padding: 5px 10px;}
  		#contTableExport {height: 350px;overflow: auto;border-bottom: 1px solid #dbdbdb;background: #f7f7f7;padding: 0px;}
        #titleSurvey {text-align: center;margin-bottom: 20px;}
        #TableAnswers {font-size: 1.2rem;}
        #TableAnswers >tbody>tr:nth-of-type(odd) { background-color: #f1f1f1; }
        #TableAnswers thead > tr > th:nth-child(5), #TableAnswers thead > tr > th:nth-child(6) {min-width: 150px;}
        #TableAnswers thead > tr > th:nth-child(13),
        #TableAnswers thead > tr > th:nth-child(14),
        #TableAnswers thead > tr > th:nth-child(15),
        #TableAnswers thead > tr > th:nth-child(16) {min-width: 200px;}
    /*Navs*/
        .tab-content.contenedor_capa {box-shadow: 0px 0px 5px 0px rgb(0 0 0 / 30%);}
    /*Containers*/
    	.panel_botones {background: #202f5c;}
        .segment-section {background: /*#f3f4f7*/#F7F8F9;border-radius: 8px;}
        .segment-table {width: 100%;border: 0;background: #f7f7f7;border-radius: 8px;padding: 10px;}
        .container-example-answer {padding: 5px 15px;background: #e5e7f5;border-radius: 5px;}
    /*Bottons*/
    	.boton {background-color: #dee8ff;color: #132c5c;border-color: #c6d4ed;}
        .btn-add {min-width: 42px;height: 34px;font-size: 1.8rem;padding: 6px 10px;border-radius: 5px;}
    	.btn-load {width: 8.7rem;height: 3.4rem;}
    	.boton:hover {color: #233f6e;background: white;}
        .boton:hover > i {color: #22527c;}
    	button.btn {outline: 0 !important;}
    /*Tables*/
    	table {margin: 0px;}
        .table-graphic {height: auto;max-height: 400px;}
    /*Texts*/
        .count {color: #3d3d3d;}
    	.control-label {color: #939393;margin: 0px;}
        .label.label-primary, .label.label-success {font-size: 1.3rem;font-weight: 500;}
    /*Icons*/
    /*Others*/
    	.active-seg {background: #D4D180;border-color: #D4D180;}
    	.active-seg > i {color: #233f6e;}
    /*Media Query*/
        @media (max-width: 1440px) {
            .container-table-bootstrap { max-width: 1162px; }
            .modal-lg { width: 1050px; }
            .modal-lg, .modal-xl { max-width: 100%; }
        }
        @media (max-width: 1280px) {
            .segment-options { max-width: 55%; }
            .container-table { max-width: 1000px;/*1030*/ }
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
<div class="contenido" id="ContentEncuestas">
    <div class="panel_botones" id="BtnMenuEncuestaS">
        <table class="tablaMenu table" id="PanelBotonesEncuestaS" style="position: sticky;top:0;">
            <tr>
                <td style="border-top: none;">
                    <div class="boton hvr-icon-grow active-seg" onclick="verContenido('divResultados','Resultados')" data-div="divResultados">
                        <i class="fas fa-list-alt hvr-icon"></i>
                        <span >Resultados</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton hvr-icon-grow" onclick="verContenido('divCrear','Crear Encuesta')" data-div="divCrear">
                        <i class="fas fa-pencil-alt hvr-icon"></i>
                        <span >Crear</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
  	<div class="contenidoPrincipal" id="ContainerContent">
        <section class="container-fluid breadcrumb-formularios">
            <div class="row">
                <div class="col-md-6 column-flex-center-start">
                    <h3 class="title-section-module">
                        <button class="btn-burguer" id="BtnMenuBurguer" title="Menú">
                            <i class="fa fa-bars" aria-hidden="true"></i></button>
                        <span id="TitleSectionTest">Encuestas de Siniestros</span>
                    </h3>
                </div>
                <div class="col-md-6 column-flex-center-end" style="display: none;">
                    <a class="btn btn-primary" onclick="consultaPrueba()">
                        <i class="fas fa-users"></i> Ir a Puestos
                    </a>
                </div>
            </div>
            <hr/>
        </section>
        <div class="divContenidoSuperE" id="divResultados">
            <?= $this->load->view('siniestros/encuesta_resultados'); ?>
        </div>
        <div class="divContenidoSuperE ocultarObjeto" id="divCrear">
            <?= $this->load->view('siniestros/encuesta_crear'); ?>
        </div>
  	</div>
</div>

<?= $this->load->view('siniestros/encuesta_modals'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<!-- <script src="<?=base_url()?>/assets/bootstrap/dist/js/bootstrap.bundle.js"></script> -->
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/libs/jsPDF/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
<script type="text/javascript">
	//Tipo de Respuestas: 1 = Todas, 2 = Numerico, 3 = V/F, 4 = Y/N, 5 = Seleccion, 6 = Abiertas
	$(document).ready(function(){
        var w = window.outerWidth;
        var h = window.outerHeight;
        console.log(w, h);

        $('#BtnMenuBurguer').click(function() {
            $('#BtnMenuEncuestaS').toggleClass('active');
            $('.container-table').toggleClass('table-width');
            $('.container-table-bootstrap').toggleClass('table-width');
        })

        /*$('#selectAnswer').change(function() {
        	input_type_option(this.value);
        })*/

        $('#selectAnswer').change();
        //getResponseSurveySiniestros(); //Desactivado
        //getCompleteInformationSurvey(); //Desactivado
        getAnswerBySurvey();
        getSurveySiniestros();
        getCountResponseSurvey();
    })

    const baseUrl = '<?=base_url()?>siniestros';

    /*function getResponseSurveySiniestros() {
    	const month = document.getElementById('searchMonth').value;
    	const year = document.getElementById('searchYear').value;
    	//console.log(month, year);
    	$.ajax({
            type: "GET",
            url: `${baseUrl}/searchInformationResponseSurvey`,
            data: {
                mt: month,
                yr: year,
                tp: 1
            },
            beforeSend: (load) => {
            	$('#btnSearch').prop('disabled',true);
                $('#btnExport').prop('disabled',true);
                $('#bodyTableResult').html(`
                    <tr>
                        <td colspan="11">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
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
                var trtd = ``;
                if (r != 0) {
                    for (const a in r) {
                        let dc = r[a].documento[0];
                        const url = `<?=base_url()?>archivosSiniestros` + dc.url + '/' + dc.archivo;
                        trtd += `
                            <tr class="show-result" data-id="${r[a].id}" data-survey="${r[a].idEncuesta}">
                                <td>${Number(a) + 1}</td>
                                <td>${r[a].folio}</td>
                                <td>${r[a].encuesta}</td>
                                <td>${getTextValue(r[a].siniestro)}</td>
                                <td>${getTextValue(r[a].poliza)}</td>
                                <td>${getTextValue(r[a].agente)}</td>
                                <!-- <td>${getTextValue(r[a].responsable_nombre)}</td> -->
                                <td>${r[a].hora_ingreso}</td>
                                <td>${getDateFormat(r[a].fecha_ingreso,1)}</td>
                                <td>${getDateFormat(r[a].fechaRespuesta,1)}</td>
                                <td><a class="btn btn-primary" href="${url}" target="_blank" download><i class="fas fa-download"></i> Descargar</a></td>
                                <td>
                                    <button class="btn btn-primary view-response" data-id="${r[a].id}"><i class="far fa-eye"></i> Ver</button>
                                </td>
                            </tr>
                        `;
                    }
                }
                else { trtd = `<tr><td colspan="11"><center><strong>Sin resultados</strong></center></td></tr>`; }
                $('#countResult').text(`(${r.length})`);
                //Asignar parametros para exportación
                $('.export-result[name="mt"]').val(month);
                $('.export-result[name="yr"]').val(year);
                //
                $('#bodyTableResult').html(trtd);
                $('#btnSearch').prop('disabled',false);
                $('#btnExport').prop('disabled',false);
                $('.view-response').click(function() {
                    const id = $(this).data('id');
                    for (a in r) {
                        if (r[a].id == id) {
                            let rs = r[a].respuestas;
                            var td = ``;
                            for (b in rs) {
                                var response = getResponseByType(rs[b].tipo,rs[b].respuesta,rs[b].opcion);
                                td += `
                                    <tr>
                                        <td>${Number(b) + 1}</td>
                                        <td>${rs[b].pregunta}</td>
                                        <td><strong>${response}</strong></td>
                                    </tr>
                                `;
                            }
                            $('#nameAsegurado').text(r[a].asegurado_nombre);
                            $('#bodyTableResponse').html(td);
                        }
                    }
                    $(".response-survey-modal").modal({
                        show: true,
                        keyboard: true,
                        backdrop: false,
                    })
                })
            },
            error: (error) => {
                console.log(error);
                $('#btnSearch').prop('disabled',false);
            }
        })
    }*/

    /*function getCompleteInformationSurvey() {
        const survey = document.getElementById('searchSurveyGeneral').value;
        const month = document.getElementById('searchMonthGeneral').value;
        const year = document.getElementById('searchYearGeneral').value;
        //console.log(survey, month, year);
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getCompleteInformationSurvey`,
            data: {
                sv: survey,
                mt: month,
                yr: year,
                tp: 1
            },
            beforeSend: (load) => {
                $('#btnSearchGenerate').prop('disabled',true);
                $('#btnExportGeneral').prop('disabled',true);
                $('#bodyTableGeneral').html(`
                    <tr>
                        <td colspan="7">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: (data) => {
                const resp = JSON.parse(data);
                console.log(resp);
                let r = resp['result'];
                var trtd = ``;
                if (r != 0) {
                    for (const a in r) {
                        let dc = r[a].documentos;
                        const generate = r[a].generadas.length;
                        const completed = r[a].resueltas.length;
                        var evidence = 0;
                        for (const b in dc) {
                            if (dc[b].documento != 0) { evidence++; }
                        }
                        const percentage = (evidence != 0) ? ((completed / evidence) * 100) : 0;
                        var status = "success";
                        if (percentage >= 60 && percentage < 80) { status = "warning"; }
                        else if (percentage < 60) { status = "danger"; }
                        trtd += `
                            <tr>
                                <td>${Number(a) + 1}</td>
                                <td>${getTextValue(r[a].descripcion)}</td>
                                <td>${r[a].titulo}</td>
                                <td>${dc.length}</td>
                                <td>${completed}</td>
                                <td class="${status}"><b>${getNumberInteger(percentage)}%</b></td>
                                <td>
                                    <button class="btn btn-primary" onclick="getAnswerBySurvey(${r[a].idEncuesta},'${r[a].titulo}',${month},${year})"><i class="far fa-eye"></i> Ver</button>
                                </td>
                            </tr>
                        `;
                    }
                }
                else { trtd = `<tr><td colspan="7"><center><strong>Sin resultados</strong></center></td></tr>`; }
                $('#bodyTableGeneral').html(trtd);
                $('#btnSearchGenerate').prop('disabled',false);
                $('#btnExportGeneral').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
                $('#btnSearchGenerate').prop('disabled',false);
                $('#btnExportGeneral').prop('disabled',false);
            }
        })
    }*/

    function getAnswerBySurvey() {
        const id = document.getElementById('searchSurvey').value;
        const month = document.getElementById('searchMonth').value;
        const year = document.getElementById('searchYear').value;
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getCompleteInformationSurvey`,
            data: {
                sv: id,
                mt: month,
                yr: year,
                tp: 1
            },
            beforeSend: (load) => {
                $('#btnExportAnswer').prop('disabled',true);
                $('#contTableAnswers').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },
            success: (data) => {
                const resp = JSON.parse(data);
                console.log(resp);
                let rs = resp['result'][0];
                let gn = rs.generadas;
                let pg = rs.preguntas;
                let rp = rs.resueltas;
                var table = `<table class="table table-striped" id="TableAnswers"><thead class="table-thead"><tr class="table-tr"><th>N°</th><th>Folio</th><th>Siniestro</th><th>Póliza</th><th>Agente</th><th>Asegurado</th><th>Hora Ingreso</th><th>Fecha Ingreso</th><th>Estado</th><th>Fecha Creación</th><th>Fecha Respuesta</th><th>Documento</th>`;
                var num = 0;
                //Integrar preguntas
                for (a in pg) {
                    table += `<th>${pg[a].pregunta}</th>`;
                }
                table += `</tr></thead><tbody id="bodyTableAnswers">`;
                //Agregar datos
                for (b in gn) {
                    num++;
                    let dc = gn[b].documento;
                    let an = gn[b].respuestas;
                    const active = (gn[b].contestado != "0") ? "Resuelto" : "Pendiente";
                    const clase = (gn[b].contestado != "0") ? "success" : "primary";
                    const url = `<?=base_url()?>archivosSiniestros` + dc[0].url + '/' + dc[0].archivo;
                    var td = ``;
                    for (c in pg) {
                        td += `<td>`;
                        for (d in an) {
                            if (an[d].idPregunta == pg[c].idPregunta) {
                                td += getResponseByType(an[d].tipo,an[d].respuesta,an[d].opcion);
                            }
                        }
                        td += `</td>`;
                    }
                    table += `
                        <tr class="show-answers">
                            <td>${num}</td>
                            <td>${gn[b].folio}</td>
                            <td>${getTextValue(gn[b].siniestro)}</td>
                            <td>${getTextValue(gn[b].poliza)}</td>
                            <td>${getTextValue(gn[b].agente)}</td>
                            <td>${getTextValue(gn[b].asegurado_nombre).toUpperCase()}</td>
                            <td>${getTextValue(gn[b].hora_ingreso)}</td>
                            <td>${getDateFormat(gn[b].fecha_ingreso,1)}</td>
                            <td><label class="label label-${clase}">${active}</label></td>
                            <td>${getDateFormat(gn[b].fechaCreacion,2)}</td>
                            <td>${getDateFormat(gn[b].fechaRespuesta,2)}</td>
                            <td><a class="btn btn-primary" href="${url}" target="_blank" download><i class="fas fa-download"></i> Descargar</a></td>
                            ${td}
                        </tr>
                    `;
                }
                table += `</tbody></table>`;
                //else { table = `<center><strong>Sin resultados</strong></center>`; }
                $('.export-answers[name="sv"]').val(id);
                $('.export-answers[name="mt"]').val(month);
                $('.export-answers[name="yr"]').val(year);
                $('#contTableAnswers').html(table);
                $('#btnExportAnswer').prop('disabled',false);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function getCountResponseSurvey() {
        const survey = document.getElementById('searchSurveyGraphic').value;
        const month = document.getElementById('searchMonthGraphic').value;
        const year = document.getElementById('searchYearGraphic').value;
        console.log(survey, month, year);
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getCompleteInformationSurvey`,
            data: {
                sv: survey,
                mt: month,
                yr: year,
                tp: 1
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                const resp = JSON.parse(data);
                //console.log(resp);
                let rs = resp['result'][0];
                let gn = rs.generadas;
                let pg = rs.preguntas;
                let rp = rs.resueltas;
                let dataG = [];
                var ul = `<ul class="nav nav-tabs nav-light">`;
                var tab = ``;
                for (a in pg) {
                    const active = (a == 0) ? "active" : "";
                    var numQ = Number(a) + 1;
                    let dd = [{[0]:pg[a].idPregunta, [1]:pg[a].pregunta, [2]:pg[a].respuesta, [3]:pg[a].tipo, [4]:pg[a].opciones, [5]:numQ, [6]:rp}];
                    let draw = draw_tr_table_question(dd[0]);
                    //console.log(dd);
                    ul += `<li class="nav-item"><a class="nav-tab-link ${active}" aria-current="page" href="#Q${numQ}" role="tab" data-toggle="tab">Pregunta ${numQ}</a></li>`;
                    tab += `<div class="col-md-12 tab-pane pd-left pd-right ${active}" id="Q${numQ}">${draw[0]}<div class="col-md-12 segment-table" id="QGraphic${numQ}" style="margin-bottom: 20px;"></div></div>`;
                    dataG.push(draw[1]);
                }
                ul += `</ul>`;
                //console.log(dataG);
                $('#navTablesResponseGraphic').html(ul);
                $('#tabsTablesResponseGraphic').html(tab);
                for (let i=0;i<dataG.length;i++) {
                    //console.log(dataG[i][0],dataG[i][1],dataG[i][2],dataG[i][3]);
                    graphicLine(dataG[i][0],dataG[i][1],dataG[i][2],dataG[i][3]);
                }

            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function getSurveySiniestros() {
    	$.ajax({
            type: "GET",
            url: `${baseUrl}/getCreatedSurveys`,
            beforeSend: (load) => {
                $('#bodyTableSurvey').html(`
                    <tr>
                        <td colspan="11">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
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
                //console.log(r);
                var trtd = ``;
                if (r != 0) {
                	for (const a in r) {
                		var response_type = "";
                		var checkY = "";
                		var checkN = "";
                		switch(r[a].tipo) {
                			case '1': response_type = "Todas"; break;
                			case '2': response_type = "Numérico"; break;
                			case '3': response_type = "Verdadero/Falso"; break;
                			case '4': response_type = "Sí/No"; break;
                            case '5': response_type = "Selección"; break;
                            case '6': response_type = "Respuestas Abiertas"; break;
                		}
                		switch(r[a].activa) {
                			case '0': checkY = "checked"; break;
                			case '1': checkN = "checked"; break;
                		}
                		trtd += `
                			<tr>
                				<td>${r[a].idEncuesta}</td>
                				<td>${r[a].titulo}</td>
                				<td>${getTextValue(r[a].nombre_ramo)}</td>
                				<td>${response_type}</td>
                				<td>${getTextValue(r[a].descripcion)}</td>
                				<td>${getDateFormat(r[a].registro,2)}</td>
                				<td>
                					<input type="radio" class="form-check-input" name="check-activate${r[a].idEncuesta}" value="1" ${checkY} disabled>
                                    <label class="form-check-label">Sí</label>
                				</td>
                				<td>
                					<input type="radio" class="form-check-input" name="check-activate${r[a].idEncuesta}" value="2" ${checkN} disabled>
                                    <label class="form-check-label">No</label>
                				</td>
                				<td>
                					<a class="btn btn-primary" href="<?=base_url()?>siniestros/encuesta_vista_ejemplo?id=${r[a].idEncuesta}" target="_blank"><i class="far fa-eye"></i> Ver</a>
                				</td>
                				<td>
                					<button class="btn btn-primary create-question" onclick="getSearchQuestions(${r[a].idEncuesta},'${r[a].tipo}','${r[a].titulo}')"><i class="fas fa-sticky-note"></i> Crear</button>
                				</td>
                				<td>
                					<button class="btn btn-primary edit-survey" data-survey="${r[a].idEncuesta}"><i class="fas fa-edit"></i> Editar</button>
                				</td>
                			</tr>
                		`;
                	}
                }
                else { trtd = `<tr><td colspan="11"><center><strong>Sin resultados</strong></center></td></tr>`; }
                $('#bodyTableSurvey').html(trtd);
                $('.edit-survey').click(function() {
                    const id = $(this).data('survey');
                    for (const a in r) {
                        if (r[a].idEncuesta == id) {
                            $('#titleSurvey').text(r[a].titulo);
                            $('input[name="update-survey"][data-field="id"]').val(r[a].idEncuesta);
                            $('input[name="update-survey"][data-field="titulo"]').val(r[a].titulo);
                            $('select[name="update-survey"][data-field="idRamo"] option[value="'+r[a].idRamo+'"]').prop('selected',true);
                            $('select[name="update-survey"][data-field="tipo"] option[value="'+r[a].tipo+'"]').prop('selected',true);
                            $('textarea[name="update-survey"][data-field="descripcion"]').val(r[a].descripcion);
                            $('textarea[name="update-survey"][data-field="descripcion"]').keyup();
                            if (r[a].preguntas.length > 0) {
                                $('select[name="update-survey"][data-field="tipo"]').prop('disabled',true);
                            }
                            else {
                                $('select[name="update-survey"][data-field="tipo"]').prop('disabled',false);
                            }
                        }
                    }
                    //console.log(id);
                    $(".edit-survey-modal").modal({
                        show: true,
                        keyboard: true,
                        backdrop: false,
                    })
                })
            },
            error: (error) => {
                console.log(error);
                $('#bodyTableSurvey').html(`<tr><td colspan="11"><center><strong>Sin resultados</strong></center></td></tr>`);
            }
        })
    }

    function getSearchQuestions(id,type,title) {
        document.getElementById('Crear').scrollIntoView();
        input_options_question(type);
        $('#SelectedSurvey').text(title);
        $('input[name="create-question"][data-field="idEncuesta"]').val(id);
        $('textarea[name="create-question"][data-field="pregunta"]').val("");
        $('#btnCrearPregunta').prop('disabled',false);
        getQuestionsSurveySiniestros(id);
    }

    function getQuestionsSurveySiniestros(id) {
    	$.ajax({
            type: "GET",
            url: `${baseUrl}/getCreatedQuestionsOfSurvey`,
            data: { id: id },
            beforeSend: (load) => {
                $('#bodyTableQuestion').html(`
                    <tr>
                        <td colspan="8">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
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
                //console.log(r);
                var trtd = ``;
                if (r != 0) {
                    for (const a in r) {
                        var response_type = "";
                        switch(r[a].tipo) {
                            case '1': response_type = "Opcional"; break;
                            case '2': response_type = "Numérico"; break;
                            case '3': response_type = "Verdadero/Falso"; break;
                            case '4': response_type = "Sí/No"; break;
                            case '5': response_type = "Selección"; break;
                            case '6': response_type = "Respuestas Abiertas"; break;
                        }
                        trtd += `
                            <tr class="show-question" data-id="${r[a].idPregunta}">
                                <td>${Number(a) + 1}</td>
                                <td>${r[a].pregunta}</td>
                                <td>${response_type}</td>
                                <td>${r[a].respuesta}</td>
                                <td>${getDateFormat(r[a].registro,1)}</td>
                                <td>${getDateFormat(r[a].modificado,1)}</td>
                                <td>
                                    <button class="btn btn-primary edit-question" data-question="${r[a].idPregunta}"><i class="fas fa-edit"></i> Editar</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger delete-question" onclick="delete_Question(${r[a].idPregunta},${r[a].idEncuesta})" disabled><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                        `;
                    }
                }
                else { trtd = `<tr><td colspan="8"><center><strong>Sin resultados</strong></center></td></tr>`; }
                $('#bodyTableQuestion').html(trtd);
                $('.edit-question').click(function() {
                    const id = $(this).data('question');
                    for (const a in r) {
                        if (r[a].idPregunta == id) {
                            $('input[name="update-question"][data-field="id"]').val(r[a].idPregunta);
                            $('input[name="update-question"][data-field="idEncuesta"]').val(r[a].idEncuesta);
                            $('textarea[name="update-question"][data-field="pregunta"]').val(r[a].pregunta);
                            $('textarea[name="update-question"][data-field="pregunta"]').keyup();
                            $('select[name="update-question"][data-field="tipo"] option[value="'+r[a].tipo+'"]').prop('selected',true);
                            $('select[name="update-question"][data-field="tipo"]').change();
                            $('select[name="update-question"][data-field="respuesta"] option[value="'+r[a].respuesta+'"]').prop('selected',true);
                        }
                    }
                    //console.log(id);
                    $(".edit-question-modal").modal({
                        show: true,
                        keyboard: true,
                        backdrop: false,
                    })
                })
            },
            error: (error) => {
                console.log(error);
                $('#bodyTableQuestion').html(`<tr><td colspan="7"><center><strong>Sin resultados</strong></center></td></tr>`);
            }
        })
    }

    function getOptionsByQuestion(id) {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getOptionsByQuestion`,
            data: { id: id },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                var option = `<option value="0">Ninguno</option>`;
                for (const a in r) {
                    option += `<option value="${r[a].idOpcion}">${r[a].titulo}</option>`;
                }
                $('#selectUpdateAnswer').html(option);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function create_update_Survey(action,name) {
    	let input = document.getElementsByName(name);
    	let insert = [];
    	let empty = [];
        const btn = (action == 1) ? 'CrearEncuesta' : 'ActualizarEncuesta';
        const title_s = (action == 1) ? '¡Creado!' : '¡Actualizado!';
        const text_s = (action == 1) ? 'Encuesta creada exitósamente.' : 'Información de la encuesta actualizada.';
    	var li = ``;
    	for (let i=0;i<input.length;i++) {
    		const field = $(input[i]).data('field');
    		const val = input[i].value;
    		let add = {};
    		if (input[i].value != 0) {
    			//add[field] = val;
    			//Primero se agregan la primera columna y luego la segunda
    			insert.push(val);
    		}
    		else {
    			if (field != "descripcion") {
    				li += (li != 0) ? `, ` + $(input[i]).attr('title') : $(input[i]).attr('title');
    				empty.push($(input[i]).attr('title'));
    			}
    		}
    	}
    	//console.log(empty);
    	if (empty != 0) {
    		swal('¡Espera!', 'Parece que los siguientes campos están vacíos: '+li, 'warning');
    	}
    	else {
    		//console.log(insert);
    		$.ajax({
        	    type: "POST",
        	    url: `${baseUrl}/insertDataForCreateSurvey`,
        	    data: {
                    ac: action,
        	    	in: insert
        	    },
        	    beforeSend: (load) => {
        	    	$('#btn'+btn).html(`
        	            <div class="container-spinner-btn-loading">
                    	    <div class="spinner-border" role="status">
                    	        <span class="visually-hidden"></span>
                    	    </div>
                    	</div>
        	        `);
        	    },
        	    success: (data) => {
        	        const r = JSON.parse(data);
        	        //console.log(r);
        	        $('#btn'+btn).html(`<i class="fas fa-save"></i> Guardar`);
        	        swal(title_s, text_s, 'success');
        	        getSurveySiniestros();
        	    },
        	    error: (error) => {
        	        console.log(error);
        	        $('#btn'+btn).html(`<i class="fas fa-save"></i> Guardar`);
                    swal('¡Uups!', 'Hay problemas al intentar guardar la información.', 'error');
        	    }
        	})
    	}
    }

    function create_update_Question(action,name) {
        let input = document.getElementsByName(name);
        let insert = [];
        let empty = [];
        const btn = (action == 1) ? 'CrearPregunta' : 'ActualizarPregunta';
        const title_s = (action == 1) ? '¡Creado!' : '¡Actualizado!';
        const text_s = (action == 1) ? 'Pregunta creada exitósamente.' : 'Información de la pregunta actualizada.';
        var li = ``;
        for (let i=0;i<input.length;i++) {
            const field = $(input[i]).data('field');
            const val = input[i].value != 0 ? input[i].value : "";
            if (input[i].value != 0 || field == "respuesta") {
                insert.push(val);
            }
            else {
                if (field != "respuesta") {
                    li += (li != 0) ? `, ` + $(input[i]).attr('title') : $(input[i]).attr('title');
                    empty.push($(input[i]).attr('title'));
                }
            }
        }
        console.log(empty);
        if (empty != 0) {
            swal('¡Espera!', 'Parece que los siguientes campos están vacíos: '+li, 'warning');
        }
        else {
            console.log(insert);
            $.ajax({
                type: "POST",
                url: `${baseUrl}/insertDataForCreateQuestion`,
                data: {
                    ac: action,
                    in: insert
                },
                beforeSend: (load) => {
                    $('#btn'+btn).html(`
                        <div class="container-spinner-btn-loading">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);
                },
                success: (data) => {
                    const r = JSON.parse(data);
                    //console.log(r);
                    let dd = r['insert'];
                    $('#btn'+btn).html(`<i class="fas fa-save"></i> Guardar`);
                    swal(title_s, text_s, 'success');
                    getQuestionsSurveySiniestros(dd['idEncuesta']);
                },
                error: (error) => {
                    console.log(error);
                    $('#btn'+btn).html(`<i class="fas fa-save"></i> Guardar`);
                    swal('¡Uups!', 'Hay problemas al intentar guardar la información.', 'error');
                }
            })
        }
    }

    function create_option_Question(id) {
        const val = document.getElementsByName('create-option')[0].value;
        console.log(id, val);
        if (val != 0) {
            $.ajax({
                type: "POST",
                url: `${baseUrl}/insertOptionsByQuestion`,
                data: {
                    id: id,
                    tx: val
                },
                beforeSend: (load) => {
                    $('#btnAddOption').html(`
                        <div class="container-spinner-btn-loading" style="padding: 0px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    `);
                },
                success: (data) => {
                    const r = JSON.parse(data);
                    //console.log(r);
                    $('#btnAddOption').html(`<i class="fas fa-plus"></i>`);
                    getOptionsByQuestion(id);
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }
    }

    function delete_Question(id,survey) {
        swal({
            title: "¿Desea eliminarlo?",
            text: "La pregunta se eliminará de la encuesta permanentemente.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                console.log(id, survey);
                $.ajax({
                    type: "POST",
                    url: `<?=base_url()?>/deleteQuestion`,
                    data: {
                        id: id
                    },
                    beforeSend: (load) => {
                    },
                    success: (data) => {
                        const r = JSON.parse(data);
                        //console.log(r);
                        if (r['status'] == true) {
                            swal("¡Eliminado!", "Pregunta eliminada con éxito.", "success");
                            getQuestionsSurveySiniestros(survey);
                        }
                    },
                    error: (error) => {
                        console.log(error);
                        swal("¡Vaya!", "Hay conflicto al intentar eliminar.", "error");
                    }
                })
            }
        })
    }

    function consultaPrueba(id,month,year) {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getCompleteInformationSurvey`,
            data: {
                sv: id,
                mt: month,
                yr: year,
                tp: 2
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function getResponseByType(type,response,option) {
        var answer = response;
        switch(type) {
            case '1': answer = option;
            break;
            case '3': answer = (response == "V") ? "Verdadero" : "Falso";
            break;
            case '4': answer = (response == "Y") ? "Sí" : "No";
            break;
        }
        return answer;
    }

    function draw_tr_table_question(r) {
        let op = r[4];
        let rs = r[6];
        let options = [];
        let response = [];
        var div = `<div class="col-md-12 segment-table" style="margin-bottom: 20px;"><div class="col-md-12 container-table table-graphic">`;
        var colspan = 0;
        var th = ``;
        var td = ``;
        switch(r[3]) {
            case '1':
                for (a in op) { const val = op[a].titulo; options.push(val); count++; }
            break;
            case '2':
                for (let i=0;i<10;i++) { const val = i + 1; options.push(val); count++; }                
            break;
            case '3':
                let opB = [{[0]:"Verdadero", [1]:"Falso"}][0];
                for (let i=0;i<2;i++) { const val = opB[i]; options.push(val); count++; }
            break;
            case '4':
                let opt = [{[0]:"Sí", [1]:"No"}][0];
                for (let i=0;i<2;i++) { const val = opt[i]; options.push(val); count++; }
            break;
            case '5':
                for (a in op) { const val = op[a].titulo; options.push(val); count++; }
            break;
            case '6': options.push("Respuesta"); count++; break;
        }
        //console.log(options);
        for (let i=0;i<options.length;i++) {
            var count = 0;
            th += `<th class="title-table">${options[i]}</th>`;
            for (a in rs) {
                rs[a].respuestas.forEach((e) => {
                    if (e.idPregunta == r[0]) {
                        if (e.tipo == '1' || e.tipo == '5') {
                            if (e.opcion == options[i]) { count++; }
                        }
                        else if (e.tipo == '2' || e.tipo == '6') {
                            if (e.respuesta == options[i]) { count++; }
                        }
                        else if (e.tipo == '3' || e.tipo == '4') {
                            switch(e.respuesta) {
                                case 'V': if (options[i] == "Verdadero") { count++; } break;
                                case 'F': if (options[i] == "Falso") { count++; } break;
                                case 'Y': if (options[i] == "Sí") { count++; } break;
                                case 'N': if (options[i] == "No") { count++; } break;
                            }
                        }
                    }
                })
            }
            td += `<td><center><strong>${count}</strong></center></td>`;
            response.push(count);
        }
        let graphic = [];
        let add = {};
        add[0] = options;
        add[1] = response;
        add[2] = "Resultados";
        add[3] = `QGraphic${r[5]}`;
        graphic.push(add);
        //console.log(graphic);
        //Planeador el martes | Respuesta A1
        div += `<table class="table table-striped" id="TableQ${r[5]}"><thead class="table-thead"><tr class="tr-style"><th colspan="${options.length}" class="title-table">${r[1]}</th></tr><tr class="tr-style">${th}</tr></thead><tbody><tr>${td}</tr></tbody></table>`;
        div += `</div></div>`;
        let data = [{[0]:div, [1]:graphic[0]}][0];
        //console.log(data);
        return data;
    }

    function input_options_question(type) {
    	var option = ``;
    	switch(type) {
    		case '1':
                option = `<option value="1">Opcional (Crear opciones)</option><option value="2">Numérico (1...10)</option><option value="3">Verdadero/Falso</option><option value="4">Sí/No</option><!-- <option value="5">Selección</option> --><option value="6">Respuesta Abierta</option>`;
    		break;
    		case '2':
                option = `<option value="2">Numérico (1...10)</option>`;
    		break;
    		case '3':
                option = `<option value="3">Verdadero/Falso</option>`;
    		break;
    		case '4':
                option = `<option value="4">Sí/No</option>`;
    		break;
    		case '5':
                option = `<option value="5">Selección</option>`;
    		break;
            case '6':
                option = `<option value="6">Respuesta Abierta</option>`;
            break;
    	}
    	$('#selectAnswer').html(option);
    }

    function input_type_option(type,action) {
        const id = (action == "update") ? $('input[name="update-question"][data-field="id"]').val() : 0;
    	var div = `<label class="textForm">Respuesta Correcta (Solo si lo requiere):</label>`;
    	var example = ``;
        var container = ``;
    	switch(type) {
    		case '1':
                const text = (action == "create") ? `Para utilizar este tipo de respuesta y crear una <b>opción</b> primero debes guardar la pregunta.` : `Para agregar una opción para respuesta solo debes crearlo en <b>Agregar Opción</b>`;
    			div = `<label class="textForm">Crea una opción:</label><br><label class="mg-cero">${text}</label>
    			`;
    			example = `
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="1">
                    <label class="form-check-label">Opción 1</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="2">
                    <label class="form-check-label">Opción 2</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="3">
                    <label class="form-check-label">Opción 3</label>
                  </div>
                `;
                if (action == "update") {
                    container = `
                        <div class="col-md-6 pd-left">
                            <label class="textForm">Agregar Opción:</label>
                            <div class="column-flex-center-start">
                                <input type="text" class="form-control" name="create-option">
                                <button class="btn btn-primary btn-add mg-left" id="btnAddOption" onclick="create_option_Question(${id})"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 pd-right">
                            <label class="textForm">Respuesta Correcta (Solo si lo requiere):</label>
                            <select class="form-control" id="selectUpdateAnswer" name="update-question" title="Respuesta" data-field="respuesta"></select>
                        </div>
                    `;
                }
    		break;
    		case '2':
                div += `<select class="form-control" name="${action}-question" title="Respuesta" data-field="respuesta">
                    <option value="0">Ninguno</option>`;
                for (let i=0;i<10;i++) {
                    div += `<option value="${i + 1}">${i + 1}</option>`;
                    example += `
                    <div class="form-check column-flex-center-center">
                      <input type="radio" class="form-check-input" name="example" value="${i + 1}">
                      <label class="form-check-label">${i + 1}</label>
                    </div>`;
                }
    			div += `</select>`;
    		break;
    		case '3':
    			div += `<select class="form-control" name="${action}-question" title="Respuesta" data-field="respuesta"><option value="0">Ninguno</option><option value="V">Verdadero</option><option value="F">Falso</option></select>`;
    			example = `
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="1">
                    <label class="form-check-label">Verdadero</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="2">
                    <label class="form-check-label">Falso</label>
                  </div>
                `;
    		break;
    		case '4':
    			div += `<select class="form-control" name="${action}-question" title="Respuesta" data-field="respuesta"><option value="0">Ninguno</option><option value="Y">Sí</option><option value="N">No</option></select>`;
    			example = `
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="1">
                    <label class="form-check-label">Sí</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="radio" class="form-check-input" name="example" value="2">
                    <label class="form-check-label">No</label>
                  </div>
                `;
    		break;
    		case '5': //Desactivado, requiere tiempo para crearlo
    			div += `<select class="form-control" name="${action}-question" title="Respuesta" data-field="respuesta"><option value="0">Ninguno</option><option value="1">Variadas</option></select>`;
    			example = `
                  <div class="form-check column-flex-center-center">
                    <input type="checkbox" class="form-check-input" name="example" value="1">
                    <label class="form-check-label">1</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="checkbox" class="form-check-input" name="example" value="2">
                    <label class="form-check-label">2</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="checkbox" class="form-check-input" name="example" value="3">
                    <label class="form-check-label">3</label>
                  </div>
                  <div class="form-check column-flex-center-center">
                    <input type="checkbox" class="form-check-input" name="example" value="4">
                    <label class="form-check-label">4</label>
                  </div>
                `;
    		break;
    		case '6':
    			div += `<input type="text" class="form-control" name="${action}-question" title="Respuesta" data-field="respuesta" placeholder="No requiere de una respuesta específica.">`;
    			example = `<input type="type" class="form-control" placeholder="Escribe tu respuesta.">`;
    		break;
    	}
        if (action == "create") {
            $('#contAnswer').html(div);
            $('#contAnswerExample').html(example);
        }
        else {
            $('#contUpdateAnswer').html(div);
            $('#contOption').html(container);
            getOptionsByQuestion(id);
        }
    }

//------------------------------------------------- OPERACIONES --------------------------------------------------

    function graphicLine(datax,datay,titleG,graphic) {
        var options = {
            series: [{
                name: 'Respuestas',
                data: datay
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            colors: ['#3E40B5', '#3EB1B5'],
            title: {
                text: titleG
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                //type: 'datetime',
                categories: datax,
                labels: {
                  rotate: -45,
                  rotateAlways: true,
                  //hideOverlappingLabels: true,
                  trim: true,
                  maxHeight: 150, //Height contenedor de las categorías
                },
            },
            yaxis: {
                title: {
                  text: 'Personas',
                },
            },
            /*tooltip: {
                x: {
                  format: 'dd/MM/yy HH:mm'
                },
            },*/
        };
        $('#'+graphic).html("");
        var chart = new ApexCharts(document.querySelector("#"+graphic), options);
        chart.render();
    }

    function filterSelectedTable(obj,body,clase) {
    	const val = $(obj).val().toUpperCase();
        filterTable(val,body,clase);
        //getCountResultByTable(body,clase);
        let tr = $('#'+body).find('tr.'+clase);
        const count = body.split('bodyTable');
        $('#count'+count[1]).text(`(${tr.length})`);
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

    function searchFilterTable(filter,val) {
      	$('#'+filter).val(val);
      	$('#'+filter).keyup();
    }

    function eraserFilterTable(filter) {
    	$('#'+filter).val("");
    	$('#'+filter).keyup();
  	}

    function update_counter(obj,counter){
        $(counter).html(obj.value.length);
    }

    function verContenido(div,title){
        let clas=document.getElementsByClassName('divContenidoSuperE');
        let select = document.getElementsByClassName('boton');
        let cant=clas.length;
        for(let i=0;i<cant;i++){clas[i].classList.remove('verObjeto');clas[i].classList.add('ocultarObjeto');}
        if(document.getElementById(div)){document.getElementById(div).classList.remove('ocultarObjeto');}
        if(document.getElementById(div)){
            document.getElementById(div).classList.add('verObjeto');
            $('#TitleSectionTest').html(title);
        };
        for(var i=0;i<select.length;i++){
            select[i].classList.remove('active-seg');
            if(select[i].getAttribute('data-div')==div){select[i].classList.add('active-seg');}
        }
    }

    function iconFunction(event,type) {
        const icon = $(event).children('i');
        if (type == 1) {
            icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
        }
        else if (type == 2) {
            icon.attr('class', icon.hasClass('fa fa-info-circle') ? 'fas fa-info' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-info-circle') ? 'Ver Info' : 'Ocultar Info');
        }
        else if (type == 3) {
            icon.attr('class', icon.hasClass('fas fa-plus') ? 'fas fa-minus' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fas fa-plus') ? 'Ver' : 'Ocultar');
        }
    }

    function getNumberInteger(data) {
        data = (Number.isInteger(data) != true) ? data.toFixed(2) : data;
        return data
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

	function getDateFormat(data,format) {
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
            switch (format) {
                case 1:
                    dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 2:
                    dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 3:
                    //fecha.replace(/[-]/g, "/"); //Reemplaza todas "-" por "/"
                    dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
                break;
                case 4:
                    dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
                break;
                case 5:
                    dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
                break;
                case 6:
                    dateF = dayname[date.getDay()];
                break;
                case 7:
                    dateF = monthname[date.getMonth()];
                break;
                case 8:
                    dateF = date.getFullYear();
                break;
                case 9:
                    if (!data.includes('00:00:00')) { dateF = date.toLocaleTimeString('en-US'); }
                break;
                case 10:
                    dateF = dayname[date.getDate()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
                break;
            }
        }
        return dateF;
    }

//----------------------------------------------- OPERACIONES PHP ------------------------------------------------

    <?
    	function print_ramo($data) {
    		$option = "";
    		foreach ($data as $val) {
    			$id = gettype($val) != "object" ? $val['IDRamo'] : $val->IDRamo;
    			$name = gettype($val) != "object" ? $val['Nombre'] : $val->Nombre;
    			$selected = ($id == 3) ? "selected" : "";
    			$option .= '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
    		}
    		return $option;
    	}

        function print_survey($data) {
            $option = '';
            foreach ($data as $val) {
                $option .= '<option value="'.$val->idEncuesta.'">'.$val->titulo.'</option>';
            }
            return $option;
        }
    ?>
    //ALTER TABLE encuesta_siniestro_respuesta RENAME encuesta_siniestro_calificacion
    //ALTER TABLE `encuesta_siniestro_calificacion` RENAME `encuesta_siniestro_estatus`
</script>