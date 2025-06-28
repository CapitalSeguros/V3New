var questions = [];
var _ques = [];
const $path = $("#base_url").attr("data-base-url");
const id = $('#surveyElement').attr('data-id-eva');
const ide = $('#jsEvaluacionId').val();
const idPe = $("#jsPeriodo").val();
const idp = $("#jsPuesto").val();
var respuesta = undefined;
$(document).ready(function () {

    $.ajax({
        type: 'GET',
        url: `${$path}evaluaciones/getPreguntas/${id}/${ide}/${idPe}/${idp}`,
        dataType: 'json',
        success: function (response) {
            //console.log("DATA",response.data);
            if (response.data.respuesta.length > 0)
                respuesta = response.data.respuesta;
            else
                respuesta = "{}";

            _ques = response.data.pregunta;
            const tipo_preguntas = JSON.parse($('#js-tipo-pregunta').attr('data-tipo-pregunta'));
            //console.log("Tipo",tipo_preguntas);
            const model = createModel(response.data.pregunta, tipo_preguntas, response.data.respuesta, response.data.template);
            initSurvey(model);
        },
        error: function (xhr) {
            console.log('error', xhr);
        }
    });
});

function doStartPage() {
    if (!survey.isCurrentPageHasErrors) {
        saveRespuesta(survey.data, true);
        $("#surveyStart").hide();
        startPage = false;
        survey.nextPage();
    }
}

function doChangePage() {
    if (!survey.isCurrentPageHasErrors) {
        saveRespuesta(survey.data);
        survey.nextPage();
    }
}

function saveRespuesta(data, start = false, complete = false) {
    //console.log("jsondata",data);
    $.ajax({
        type: 'POST',
        url: `${$path}evaluaciones/postRespuesta`,
        dataType: 'json',
        data: {
            "id": id,
            "ev_p_id": idPe,
            "start": start,
            "questions": complete ? _ques : [],
            "complete": complete,
            "respuesta": JSON.stringify(data)
        },
        success: function (response) {
            if (complete) {
                window.location = `${$path}miInfo#evaluaciones`;
            }
            //console.log('Res',response);
        },
        error: function (xhr) {
            //console.log('error', xhr);
        }
    });
}

function doOnCurrentPageChanged(survey) {
    const pbar = document.querySelector('.progress-bar');

    const total = parseInt(survey.visiblePageCount);
    const pCur = parseInt((survey.currentPageNo + 1));
    const por = (pCur / total) * 100;
    pbar.style["width"] = `${por}%`;

    document
        .getElementById('surveyProgress')
        .innerText = "Competencia " + (
            survey.currentPageNo + 1) + " de " + survey.visiblePageCount + ".";
    document
        .getElementById('surveyNext')
        .style
        .display = !survey.isLastPage && !startPage ?
        "inline" :
        "none";
    document
        .getElementById('surveyComplete')
        .style
        .display = survey.isLastPage ?
        "inline" :
        "none";
}

function surveyValidateQuestion(s, options) {
    toastr.error(options.text);
}

function initSurvey(pages) {

    var ob_respuesta = JSON.parse(respuesta);
    console.log("obrepuesta",ob_respuesta);
    if (pages.currentPage === pages.pages.length) {
        //'js-result'
        showResult(pages, ob_respuesta);
        return;
    }
    $('#js-container-control').removeClass('hidden');
    Survey
        .StylesManager
        .applyTheme("bootstrap");
    Survey.defaultBootstrapCss.navigationButton = "btn btn-green";
    var json = {
        "pages": pages.pages
    };
    window.survey = new Survey.Model(json);

    survey
        .onComplete
        .add(function (result) {
            saveRespuesta(result.data, false, true);
        });

    survey.data = ob_respuesta;
    survey.currentPageNo = pages.currentPage;
    survey.sendResultOnPageNext = true;
    survey.showPrevButton = false;
    survey.showNavigationButtons = false;
    survey.locale = 'es';
    survey.showTitle = false;
    survey.hideRequiredErrors = true;
    doOnCurrentPageChanged(survey);
    $("#surveyElement").Survey({
        model: survey,
        onCurrentPageChanged: doOnCurrentPageChanged,
        onErrorCustomText: surveyValidateQuestion
    });
}

function showResult(pages, ob_respuesta) {
    $('#js-container-control-result').removeClass('hidden');
    var dataSource = [];
    _.forEach(pages.pages, function (value) {
        _.forEach(value.questions, function (val) {
            dataSource.push(val);
        });
    });

    $('#js-result').DataTable({
        searching: false,
        paging: false,
        ordering: false,
        info: false,
        data: dataSource,
        columns: [{
            data: null,
            render: function (data, type, row) {
                var finalTemplate = "";
                var headTemplate = "";
                var bodyTemplate = "";
                var bdyText = "";
                var bdyCol = "";
                switch (data.type) {
                    case "matrix":
                        _.forEach(data.rows, function (value) {
                            bdyText = "";
                            bdyCol = "";
                            _.forEach(data.columns, function (v) {
                                bdyText += `<td>${data.cells[value.value][v]}</td>`;
                            });
                            var _grade = grade[data.grade];
                            var comp_respuesta = ob_respuesta[data.name];
                            var indexAlp = alphabet.findIndex(function (alp) {
                                return alp == comp_respuesta[value.value];
                            });
                            bdyText += `<td class="text-center" width="50">${comp_respuesta[value.value]}</td><td class="text-center" width="50">${_grade[indexAlp]}%</td>`;
                            _.forEach(data.columns, function (v) {
                                bdyCol += `<td class="text-center ${(comp_respuesta[value.value] == v ? 'info':'') }">${v}</td>`;
                            });
                            bodyTemplate += `<tbody>
                                                <tr class="tb-ev-header">
                                                    <th class="tb-head" colspan="6">${value.text}</th>
                                                </tr>
                                                <tr>
                                                ${bdyText}
                                                </tr>
                                                <tr class="tb-ev-footer">
                                                ${bdyCol}
                                                </tr>
                                            </tbody>`;
                        });
                        finalTemplate += `<table class="table table-condensed tb-table">${bodyTemplate}</table>`;
                        break;

                    default:
                        break;
                }
                return finalTemplate;
            }
        }],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(0, {
                page: 'current'
            }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        `<tr class="group"><td colspan="3"><strong>${group.title}</strong><span class="pull-right"><strong>Grado requerido: ${group.grade}</strong></span></td></tr>`
                    );
                    last = group;
                }
            });
        }
    });
}