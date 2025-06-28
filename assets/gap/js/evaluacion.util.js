const grade = {
    A: [100, 75, 50, 25],
    B: [100, 100, 75, 50],
    C: [100, 100, 100, 75],
    D: [100, 100, 100, 100]
}
let startPage = false
const alphabet = ["A", "B", "C", "D"];

function createModel(_questions, tipo_preguntas, _respuesta = undefined, template = "") {
console.log("respuesta",_respuesta);
console.log("TipoPreguntas",tipo_preguntas);
    var pages = [];
    if (typeof _respuesta == "object") {

        $("#surveyStart").show();
        pages.push({
            questions: [{
                type: "html",
                html: template
            }]
        });
        startPage = true;
    } else {
        $("#surveyNext").show();
    }
    var qsCompe = _.groupBy(_questions, function (e) {
        return e.competencias_id;
    });

    for (const key in qsCompe) {
        var page = {
            questions: []
        };
        const obCompetencia = qsCompe[key];
        var pByTipo = _.groupBy(obCompetencia, function (c) {
            return c.tipo_pregunta_id;
        });
        var matrix = undefined;

        for (const keyt in pByTipo) {
            const oPregs = pByTipo[keyt];
            const tipo_pregunta = tipo_preguntas.find(function (t) {
                return t.id == keyt;
            });
            console.log("Busqueda de tipo p",tipo_pregunta);
            var templateControl = JSON.parse(tipo_pregunta.json_template);

            for (const ky in oPregs) {
                const oPreg = oPregs[ky];
                page.grade = oPreg.grado;
                if (tipo_pregunta.clave == "matrix") {
                    if (matrix === undefined) {
                        matrix = templateControl;
                    }
                    var control = JSON.parse(oPreg.json_content);
                    Object.assign(matrix, {
                        title: oPreg.titulo_competencia,
                        grade: oPreg.grado,
                        name: getSlug(oPreg.titulo_competencia),
                        columns: Object.keys(control),
                        order: oPreg.orden,
                        isAllRowRequired: true,
                    });
                    const slug = getSlug(`preg ${oPreg.pregunta_id}`);
                    matrix.rows.push({
                        text: oPreg.titulo,
                        value: slug
                    });
                    matrix.cells[slug] = control;
                } else {
                    var obTmp = JSON.parse(oPreg.json_content);
                    obTmp.order = oPreg.orden;
                    obTmp.grade = oPreg.grado;
                    page.questions.push(obTmp);
                }
            }
        }
        if (matrix != undefined)
            page.questions.push(matrix);

        pages.push(page);
    }
    var resp = Object.keys(JSON.parse(respuesta));
    var currentPage = -1;
    for (const key in pages) {
        const el = pages[key];
        var titles = _.map(el.questions, function (e) {
            return e.name;
        });
        titles = _.uniq(titles);
        var all = allCollection(titles, resp);
        if (all == false && currentPage == -1)
            currentPage = parseInt(key);

        el.questions = _.orderBy(el.questions, ['order'], ['asc']);
    }
    if (currentPage == -1 && resp.length > 0) {
        currentPage = pages.length;
    }
    return {
        pages,
        currentPage
    };
}

function allCollection(arr1, arr2) {
    var all = true;
    _.forEach(arr1, function (value, key) {
        if (_.indexOf(arr2, value) == -1) {
            all = false;
        }
    });
    return all;
}