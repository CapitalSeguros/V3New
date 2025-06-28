//--------------------------------
//Options charts section
const optionsPie = {
    series: [], //Object.values(data).map(arr => arr.hours),
    chart: {
        type: "pie"
    },
    labels: [], //Object.values(data).map(arr => arr.name),
}

const optionsMontlyBars = {
    series: [],
    chart: {
        type: "bar",
        height: 350
    },
    xaxis: {
        categories: [],
        
    },
    yaxis: {
        title: {
          text: ``
        }
    },
    tooltip: {
        y: {
          formatter: function (val) {
            return val + ``
          }
        }
    }
}

const optionsSubtrainingBar = {
    series: [],
    chart: {
        type: 'bar',
    },
    xaxis: {
        categories: [],
    },
    title: {
        text: ``
    }
}

//-------------------------------

var chartPie1 = new ApexCharts($(".pie-container")[0], optionsPie);
chartPie1.render();

var chartPie2 = new ApexCharts($(".pie-container2")[0], optionsPie);
chartPie2.render();

var chartMontlyBar1 = new ApexCharts($(".general-graph")[0], optionsMontlyBars);
chartMontlyBar1.render();

var chartMontlyBar2 = new ApexCharts($(".general-graph1")[0], optionsMontlyBars);
chartMontlyBar2.render();

var chartSubtBar1 = new ApexCharts($(".bar-container")[0], optionsSubtrainingBar);
chartSubtBar1.render();

var chartSubtBar2 = new ApexCharts($(".bar-container-1")[0], optionsSubtrainingBar);
chartSubtBar2.render();
//------------------------------
$(function(){

    const baseUrl = $("#base-url").data("url");
    const paintCharts = generateInitialContent(baseUrl);

});

const generateInitialContent = (baseUrl) => {

    var ajax = $.ajax({
        type: `GET`,
        url: `${baseUrl}capacita/getTrainings`,
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            //general-graph
            const response = JSON.parse(data);
            const trainings = response.trainingsHours;
            const people = response.peopleInTraining;
            const trainingTree = response.trainingTree;
            const peopleTrainingTree = response.peopleTrainingTree;
            const montlyTrainings = response.montlyRecords;
            const montlyPeopleTrainings = response.montlyPeopleRecords;
            const months  = response.months;
            console.log(trainingTree);

            const tableInfo1 = generateTableInfo(trainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"));
            const childGraph1 = generateColumnGraph(trainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"), "hours");
            const tableInfo2 = generateTableInfo2(peopleTrainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"));
            const childGraph2 = generateColumnGraph(peopleTrainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"), "people");
            //peopleTrainingTree
            //---------------------------------------------
            //Data
            const pieData1 = {
                series: Object.values(trainings).map(arr => arr.hours),
                labels: Object.values(trainings).map(arr => arr.name)
            }

            const pieData2 = {
                series: Object.values(people).map(arr => arr.people.length),
                labels: Object.values(people).map(arr => arr.name)
            }
            //console.log(pieData2);
            const paintGeneralGraph1 = generateMontlyGraph(montlyTrainings, "cantidad de horas", "horas");
            const paintGeneralGraph2 = generateMontlyGraph(montlyPeopleTrainings, "cantidad de participantes", "personas");
            const paintPieGraph1 = generatePieGraph(pieData1, "hours"); //pie-container2
            const paintPieGraph2 = generatePieGraph(pieData2, "people");
            const generalDataTable1 = generateGeneralInfoTable(montlyTrainings, $(".general-info-table"));
            const generalDataTable2 = generateGeneralInfoTable(montlyPeopleTrainings, $(".general-info-table-1"));
            const tableTrainingInfo1 = generateTableTrainingInfo(trainings, "hours", $(".pie-info"));
            const tableTrainingInfo2 = generateTableTrainingInfo(people, "people", $(".pie-info2")); //pie-info2
            //---------------------------------------------
            //$("#month-filter").append($("<option></option>").attr);
            for(var b in months){
                $("#month-filter").append($("<option></option>").attr("value", b).text(months[b]));
            }
        }
    });
}

//---------------------------------------
const generatePieGraph = (data, type_) => {
    
    var options = {
        series: data.series, //Object.values(data).map(arr => arr.hours),
        chart: {
            type: "pie"
        },
        labels: data.labels, //Object.values(data).map(arr => arr.name),
    }

    if(type_ == "hours"){
        chartPie1.updateOptions(options);
    } else{
        chartPie2.updateOptions(options);
    }
}
//---------------------------------------
const generateGeneralInfoTable = (data, element) => {
    //console.log(data);
    const monthsTd = Object.values(data.months).reduce((acc, curr) => {
        acc += `<th>${curr}</th>`;
        return acc;
    }, ``);

    const dataTR = Object.values(data.montlyData).reduce((acc, curr) => {

        const td = curr.data.reduce((acc, curr) => acc += `<td>${curr}</td>`, ``);

        acc += `<tr><td>${curr.name}</td>${td}</tr>`;
        return acc;
    }, ``);
    
    $(element).html(`
        <table class="table">
            <thead>
                <tr>
                    <th>Capacitaciones</th>
                    ${monthsTd}
                </tr>
            </thead>
            <tbody>${dataTR}</tbody>
        </table>
    `);
}
//---------------------------------------
const generateTableTrainingInfo = (trainings, type, element) => {

    const total = type == "hours" ? 
        Object.values(trainings).reduce((acc, curr) => acc + curr.hours, 0) : 
        Object.values(trainings).reduce((acc, curr) => acc + (curr.people).length, 0);

    var rows = ``;
    var a_target = ``;
    $(element).html(``); //.pie-info
    var content = type == "hours" ? $(".filter-training") : $(".filter-training-1");

    for(var a in trainings){

        const counts = type == "hours" ? trainings[a].hours : trainings[a].people.length;
        var label = type == "hours" ? "horas" : "personas";

        const percent = (counts * 100) / total;
        rows += `<tr><td>${trainings[a].name}</td><td>${counts} ${label} - ${percent.toFixed(1)}%</td></tr>`;
        a_target += `<a class="dropdown-item training-option" href="javascript: void(0)" data-id="${a}" data-type="${type}" data-filter="" data-month="">${trainings[a].name}</a>`;
    }

    $(element).html(`
        <table class="table table-sm">
            <thead>
                <tr>
                    <th class="text-center">Capacitación</th>
                    <th class="text-center">${label}</th>
                <tr>
            </thead>
            <tbody>${rows}</tbody>
            <tfooter><tr><td>TOTAL</td><td>${total} ${label}</td></tr><tfooter>
        <table>
    `);
    $(content).html(`
        <div class="dropdown">
            <a class="" href="#" role="button" id="dpd-training" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filtrar</a>
            <div class="dropdown-menu">
                ${a_target}
            </div>
        </div>
    `);

    return;
}
//---------------------------------------
const generateMontlyGraph  = (array, title, val_) => {
    //console.log(array);

    var options = {
        series: Object.values(array.montlyData),
        chart: {
            type: "bar",
            height: 350
        },
        xaxis: {
            categories: array.months,
            
        },
        yaxis: {
            title: {
              text: title
            }
        },
        tooltip: {
            y: {
              formatter: function (val) {
                return val + ` ${val_}`
              }
            }
        }
        
    }

    if(val_ == "personas"){
        chartMontlyBar2.updateOptions(options);
    } else{
        chartMontlyBar1.updateOptions(options);
    }
}
//--------------------------------------
$(document).on("click", ".training-option", function(){

    //console.log($(this).data("id"));
    const baseUrl = $("#base-url").data("url");
    const type = $(this).data("type");
    const filter = $(this).data("filter");
    const month = $(this).data("month");

    var ajax = $.ajax({
        type: `GET`,
        url: `${baseUrl}capacita/getTrainingSelected`,
        data: { 
            id: $(this).data("id"),
            type: type,
            filter: filter == "" ? "vacio" : filter,
            month: month == "" ? 0 : month,
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            const generateTable = type == "hours" ? generateTableInfo(response) : generateTableInfo2(response)
            const generateGraph = generateColumnGraph(response, type);
        }
    });
});
//---------------------------------------

const generateColumnGraph = (data, type) => {

    //console.log(data);
    const title = data.reduce((acc, curr) => curr.tipoCapacitacion,"");
    var data_ = [];

    if(type == "people"){

        data_ = data.reduce((acc, curr) => {

            //if(curr.idSubCapacitacion !== null){
                //var validate_ = [];
                acc[curr.idSubCapacitacion] = {
                    name: curr.nombreCertificado,
                    //data: data.filter(arr2 => arr2.nombreCertificado == curr.nombreCertificado).length
                    data: [... new Set(data.reduce((acc_, curr_) => {
                        if(curr_.nombreCertificado == curr.nombreCertificado){
                            acc_.push(curr_.idPersona);
                        }
                        return acc_;
                    }, []))].length
                }
            //}
            //console.log(acc)
            return acc;
        }, {});

    } else{

        data_ = data.reduce((acc, curr) => {

            return [
                ...acc, {
                    name: curr.nombreCertificado, 
                    data: curr.horas,
                }
            ]
        },[]);
    }

    const options = {
        series: [{
            name: (type == "hours" ? "Horas" : "Personas"),
            data: Object.values(data_).map(arr => arr.data),
        }],
        chart: {
            type: 'bar',
        },
        xaxis: {
            categories: Object.values(data_).map(arr => arr.name),
        },
        title: {
            text: `Capacitación en: ${title}`
        }
    }

    if(type == "hours"){

        chartSubtBar1.updateOptions(options);
    } else{
        chartSubtBar2.updateOptions(options);
    }
}

//-----------------------------------
const generateTableInfo2 = (data) => {

    //console.log(data);
    const total = [... new Set(data.map(arr => arr.idPersona))];
    const title = data.reduce((acc, curr) => acc = curr.tipoCapacitacion, ``);
    const dataStructured = data.reduce((acc, curr) => {

        acc[curr.idSubCapacitacion] = {
            name: curr.nombreCertificado,
            people: data.reduce((acc1, curr2) => {
                if(curr2.nombreCertificado == curr.nombreCertificado){
                    acc1.push(curr2.idPersona);
                }
                return acc1;
            }, [])
        }
        return acc;
    }, {});
    console.log(dataStructured);

    const row = Object.values(dataStructured).reduce((acc, curr) => {

        //const percent = (curr.horas * 100) / total;
        return acc += `<tr><td>${curr.name}</td><td>${[... new Set(curr.people)].length} personas</td></tr>`;
    }, "");

    $(".info-subtraining-1").html(`
        <div><p>${title}</p></div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Sub-categoria</th>
                    <th>Participantes</th>
                <tr>
            </thead>
            <tbody>${row}</tbody>
            <!--<tfoot><tr><td>TOTAL</td><td>${total} hrs</td></tr></tfoot>-->
        </table>
    `);

    /*const total = data.reduce((acc, curr) => acc + parseFloat(curr.horas), 0);
    const title = data.reduce((acc, curr) => acc = curr.tipoCapacitacion, ``);
    const row = data.reduce((acc, curr) => {

        const percent = (curr.horas * 100) / total;
        return acc += `<tr><td>${curr.nombreCertificado}</td><td>${curr.horas} hrs - ${percent.toFixed(1)}%</td></tr>`;
    }, "");

    $(".info-subtraining").html(`
        <div><p>${title}</p></div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Sub-categoria</th>
                    <th>Horas</th>
                <tr>
            </thead>
            <tbody>${row}</tbody>
            <tfoot><tr><td>TOTAL</td><td>${total} hrs</td></tr></tfoot>
        </table>
    `);*/
}
//-----------------------------------
const generateTableInfo = (data) => {
    //console.log(data);
    const total = data.reduce((acc, curr) => acc + parseFloat(curr.horas), 0);
    const title = data.reduce((acc, curr) => acc = curr.tipoCapacitacion, ``);
    const row = data.reduce((acc, curr) => {

        const percent = (curr.horas * 100) / total;
        return acc += `<tr><td>${curr.nombreCertificado}</td><td>${curr.horas} hrs - ${percent.toFixed(1)}%</td></tr>`;
    }, "");

    $(".info-subtraining").html(`
        <div><p>${title}</p></div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Sub-categoria</th>
                    <th>Horas</th>
                <tr>
            </thead>
            <tbody>${row}</tbody>
            <tfoot><tr><td>TOTAL</td><td>${total} hrs</td></tr></tfoot>
        </table>
    `);
}
//-----------------------------------
$(document).on("click", ".execute-filter", function(){

    const baseUrl = $("#base-url").data("url");
    const numberMonth = $("#month-filter option:selected").val();
    const typeFilter = $("#type-filter option:selected").val();

    if(numberMonth == 0 || typeFilter == 0){
        alert("Seleccione una opción correcta");
        return false;
    }
    //console.log(numberMonth, typeFilter);

    if(typeFilter == "total"){
        const paintCharts = generateInitialContent(baseUrl);
        return false;
    }

        var ajax = $.ajax({
            type: `GET`,
            url: `${baseUrl}capacita/getTrainingFiltered`,
            data: { 
                month: numberMonth,
                typeFilter: typeFilter
            },
            error: (error) => {
                console.log(error);
            },
            success: (data) => {
                const response = JSON.parse(data);
                const trainings = response.trainingsHours;
                const people = response.peopleInTraining;
                const trainingTree = response.trainingTree;
                const peopleTrainingTree = response.peopleTrainingTree;
                const montlyTrainings = response.montlyRecords;
                const montlyPeopleTrainings = response.montlyPeopleRecords;
                const months  = response.months;
                //console.log(trainings);
                //console.log(trainingTree);

                //const tableInfo1 = generateTableInfo(trainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"));
                //const childGraph1 = generateColumnGraph(trainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"), "hours");
                //const tableInfo2 = generateTableInfo(peopleTrainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"));
                const childGraph2 = generateColumnGraph(peopleTrainingTree.filter(arr => arr.tipoCapacitacion == "CONOCIMIENTO DE PRODUCTOS"), "people");
                //---------------------------------------------
                //Data
                const pieData1 = {
                    series: Object.values(trainings).map(arr => arr.hours),
                    labels: Object.values(trainings).map(arr => arr.name)
                }

                const pieData2 = {
                    series: Object.values(people).map(arr => arr.people.length),
                    labels: Object.values(people).map(arr => arr.name)
                }

                const paintGeneralGraph1 = generateMontlyGraph(montlyTrainings, "cantidad de horas", "horas");
                const paintGeneralGraph2 = generateMontlyGraph(montlyPeopleTrainings, "cantidad de participantes", "personas");
                const paintPieGraph1 = generatePieGraph(pieData1, "hours"); //pie-container2
                const paintPieGraph2 = generatePieGraph(pieData2, "people");
                const generalDataTable1 = generateGeneralInfoTable(montlyTrainings, $(".general-info-table"));
                const generalDataTable2 = generateGeneralInfoTable(montlyPeopleTrainings, $(".general-info-table-1"));
                const tableTrainingInfo1 = generateTableTrainingInfo(trainings, "hours", $(".pie-info"));
                const tableTrainingInfo2 = generateTableTrainingInfo(people, "people", $(".pie-info2")); //pie-info2

                $(".training-option").attr("data-month", numberMonth);
                $(".training-option").attr("data-filter", typeFilter);
            }
        });
});

//-----------------------------------
$(document).on("change", "#training-for-report", function(){

    const baseUrl = $("#base-url").data("url");
    var type = $(this).val();
    //console.log(type);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}capacita/getSubtrainings`,
        data: {
            id: type
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            //console.log(response);
            const options = response.reduce((acc, curr) => acc += `<option value="${curr.id_certificado}">${curr.nombreCertificado}</option>`, ``);
            $("#sub-training-for-report").html(`<option value="">Seleccione</option>${options}`);
        }
    });
});
//-----------------------------------
$(document).on("click", ".apply-search", function(){

    const training = $("#training-for-report option:selected");
    const subTraining = $("#sub-training-for-report option:selected");
    const month = $("#month-for-report option:selected");
    const baseUrl = $("#base-url").data("url");

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}capacita/getReportFiltered`,
        data: {
            month: month.val(),
            training: training.val(),
            subTraining: subTraining.val()
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            //console.log(response);

            if(response.length > 0){

                const tbody = response.reduce((acc, curr) => {

                    const td = Object.values(curr.data).reduce((acc,curr) => acc += `<td class="text-center">${curr}</td>`, ``);
                    const total = Object.values(curr.data).reduce((acc, curr) => acc += parseFloat(curr), 0);
                    acc += `
                        <tr>
                            <td>${curr.name}</td>${td}<td>${total}</td>
                        </tr>
                    `;
                    return acc;
                }, ``);

                const profesional = response.map(arr => arr.data.profesional).reduce((acc, curr) => acc += parseFloat(curr), 0);
                const vida = response.map(arr => arr.data.vida).reduce((acc, curr) => acc += parseFloat(curr), 0);
                const danos = response.map(arr => arr.data.daños).reduce((acc, curr) => acc += parseFloat(curr), 0);
                const autos = response.map(arr => arr.data.autos).reduce((acc, curr) => acc += parseFloat(curr), 0);
                const gmm = response.map(arr => arr.data.gmm).reduce((acc, curr) => acc += parseFloat(curr), 0);
                const fianzas = response.map(arr => arr.data.fianzas).reduce((acc, curr) => acc += parseFloat(curr), 0);

                //console.log(onlyData);

                $(".content-training-1").html(`
                    <div class="card card-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Agente / Colaborador</th>
                                    <th>Profesional</th>
                                    <th>Vida</th>
                                    <th>Daños</th>
                                    <th>Autos</th>
                                    <th>GMM</th>
                                    <th>Fianzas</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>${tbody}</tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-center">${profesional}</td>
                                    <td class="text-center">${vida}</td>
                                    <td class="text-center">${danos}</td>
                                    <td class="text-center">${autos}</td>
                                    <td class="text-center">${gmm}</td>
                                    <td class="text-center">${fianzas}</td>
                                    <td class="text-center">${(profesional + vida + danos + autos + gmm + fianzas)}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                `);
            } else{
                $(".content-training-1").html(`<h4>Sin resultados</h4>`).addClass("text-center");
            }
        }
    });
});
//-----------------------------------