$(() => {

    console.log("Hola mundo");
    getAllGraphData();
});

const getAllGraphData = () => {

    const baseUrl = $("#base").val();

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}reportes/getGraphData`,
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);
            const capacitaData = Object.values(response.capacita);
            const incidenciasData = response.incidencias;
            const siniestrosData = response.siniestros;
            const marketingData = response.marketing;
            const presupuestoData = response.presupuesto;
            const ventasData = response.ventas;

            $(".capacita-container").append($("<canvas></canvas>", {id: "capacita-chart", style: "width:100%; height: 300px"}));
            $(".incidencias-container").append($("<canvas></canvas>", {id: "incidencias-chart", style: "width:100%; height: 250px"}));
            $(".siniestros-container").append($("<canvas></canvas>", {id: "siniestros-chart", style: "width:100%; height: 250px"}));
            $(".marketing-container").append($("<canvas></canvas>", {id: "marketing-chart", style: "width:100%; height: 300px"}));
            $(".control-presupuesto-container").append($("<canvas></canvas>", {id: "presupuesto-chart", style: "width:100%; height: 250px"}));
            $(".ventas-container").append($("<canvas></canvas>", {id: "ventas-chart", style: "width:100%; height: 250px"}));

            const capacitag = generateCapacitaGraph(capacitaData); //paint capacita graph
            const incidenciasg = generateIncidenciasGraph(incidenciasData); //paint incidencias graph
            const siniestrosg = generateSiniestrosGraph(siniestrosData); //paint incidencias graph
            const marketingg = generateMarketingGraph(marketingData); //paint marketing graph
            const presupuestog = generatePresupuestoGraph(presupuestoData); //paint marketing graph
            const ventasg = generateVentasGraph(ventasData); //paint marketing graph

        }
    });
}
//-----------------------
const generateVentasGraph = (ventasData) => {
    const bgColor = [
        'rgba(0, 0, 255, 0.6)',
        'rgba(60, 179, 113, 0.6)',
        'rgba(255, 0, 0, 0.6)',
        'rgba(255, 165, 0, 0.6)',
        'rgba(106, 90, 205, 0.6)',
        'rgba(238, 130, 238, 0.6)',
    ];

    const borderColor = [
        'rgba(0, 0, 255, 1)',
        'rgba(60, 179, 113, 1)',
        'rgba(255, 0, 0, 1)',
        'rgba(255, 165, 0, 1)',
        'rgba(106, 90, 205, 1)',
        'rgba(238, 130, 238, 1)',
    ];

    const marketingGraph = new Chart(
        $("#ventas-chart"), {
             type: "bar",
            data: {
                labels: ventasData.labels,
                datasets: [{
                    label: `Ventas`,
                    data: ventasData.data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },

        }
    );
}
//-----------------------
const generatePresupuestoGraph = (presupuestoData) => {

    const onlyValues = Object.values(presupuestoData);
    const labels = [];
    const presupesto = [];
    const saldo = [];
    const presupuestoPagado = [];

    for(const a in onlyValues){
        for(const b in onlyValues[a]){
            if(onlyValues[a][b].numMes == 12){

                labels.push(onlyValues[a][b].personaDepartamento);
                presupesto.push(onlyValues[a][b].presupuesto);
                saldo.push(onlyValues[a][b].saldoMes);
                presupuestoPagado.push(onlyValues[a][b].presupuestoPagado);
            }
        }
    }

    const presupuestoGraph = new Chart(
        $("#presupuesto-chart"), {
             type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: `Presupuesto`,
                        data: presupesto,
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        borderColor: 'rgba(0, 0, 255, 1)',
                        borderWidth: 1
                    },
                    {
                        label: `Saldo mensual`,
                        data: saldo,
                        backgroundColor: 'rgba(60, 179, 113, 0.2)',
                        borderColor: 'rgba(60, 179, 113)',
                        borderWidth: 1
                    },
                    {
                        label: `Presupuesto pagado`,
                        data: presupuestoPagado,
                        backgroundColor: 'rgba(255, 0, 0, 0.2)',
                        borderColor: 'rgba(255, 0, 0)',
                        borderWidth: 1
                    }
                ]
            },

        }
    );
}
//-----------------------
const generateMarketingGraph = (marketingData) => {
    const bgColor = [
        'rgba(0, 0, 255, 0.6)',
        'rgba(60, 179, 113, 0.6)',
        'rgba(255, 0, 0, 0.6)',
        'rgba(255, 165, 0, 0.6)',
        'rgba(106, 90, 205, 0.6)',
        'rgba(238, 130, 238, 0.6)',
        'rgba(180, 180, 180, 0.6)',
        'rgba(255, 99, 71, 0.6)',
        'rgba(82, 122, 162, 0.6)',
        'rgba(255, 253, 130, 0.6)'
    ];
    const borderColor = [
        'rgba(0, 0, 255, 1)',
        'rgba(60, 179, 113, 1)',
        'rgba(255, 0, 0, 1)',
        'rgba(255, 165, 0, 1)',
        'rgba(106, 90, 205, 1)',
        'rgba(238, 130, 238, 1)',
        'rgba(180, 180, 180, 1)',
        'rgba(255, 99, 71, 1)',
        'rgba(82, 122, 162, 1)',
        'rgba(255, 253, 130, 1)'
    ];

    const marketingGraph = new Chart(
        $("#marketing-chart"), {
             type: "bar",
            data: {
                labels: marketingData.labels,
                datasets: [{
                    label: `Fuente de prospecto`,
                    data: marketingData.data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },

        }
    );
}
//------------------------
const generateSiniestrosGraph = (siniestrosData) => {

    const bgColor = [
        `rgba(230, 176, 170, 0.2)`,
        `rgba(195, 155, 211, 0.2)`,
        `rgba(174, 214, 241, 0.2)`,
        `rgba(23, 165, 137, 0.2)`,
        `rgba(244, 208, 63, 0.2)`,
    ];
    const borderColor = [
        `rgba(230, 176, 170)`,
        `rgba(195, 155, 211)`,
        `rgba(174, 214, 241)`,
        `rgba(23, 165, 137)`,
        `rgba(244, 208, 63)`,
    ];

    const siniestrosGraph = new Chart(
        $("#siniestros-chart"), {
             type: "bar",
            data: {
                labels: siniestrosData.labels,
                datasets: [{
                    label: `Siniestros (eventos)`,
                    data: siniestrosData.data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },

        }
    );
}
//-----------------------
const generateIncidenciasGraph = (incidenciasData) => {
    const bgColor = [
        `rgba(230, 176, 170, 0.2)`,
        `rgba(195, 155, 211, 0.2)`,
    ];
    const borderColor = [
        `rgba(230, 176, 170)`,
        `rgba(195, 155, 211)`,
    ];

    const incidenciasGraph = new Chart(
        $("#incidencias-chart"), {
             type: "bar",
            data: {
                labels: incidenciasData.labels,
                datasets: [{
                    label: `Tipo de incidencias`,
                    data: incidenciasData.data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },

        }
    );
}
//-----------------------
const generateCapacitaGraph = (capacitaData) => {

    const capacitaLabels = capacitaData.map(arr => arr.name);
    const capacitaValues = capacitaData.map(arr => arr.hours);
    const bgColor = [
        `rgba(230, 176, 170, 0.2)`,
        `rgba(195, 155, 211, 0.2)`,
        `rgba(174, 214, 241, 0.2)`,
        `rgba(23, 165, 137, 0.2)`,
        `rgba(244, 208, 63, 0.2)`,
    ];
    const borderColor = [
        `rgba(230, 176, 170)`,
        `rgba(195, 155, 211)`,
        `rgba(174, 214, 241)`,
        `rgba(23, 165, 137)`,
        `rgba(244, 208, 63)`,
    ];

    const capacitaGraph = new Chart(
        $("#capacita-chart"), {
             type: "bar",
            data: {
                labels: capacitaLabels,
                datasets: [{
                    label: `Horas de capacitación`,
                    data: capacitaValues,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },

        }
    );
}
//-----------------------