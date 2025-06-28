$(document).on("click", ".filter-past-data", function(){

    const band = $(this).data("filter");
    const getCombos = band == "other" ? `others` : `comission`;
    const getChart = band == "other" ? chart3 : chart1;
    const year = $(`#past-years-${getCombos} option:selected`).val();
    const month = $(`#past-months-${getCombos} option:selected`).val(); //past-months-comission //past-montly-type-comission
    const type = $(`#past-montly-type-${getCombos} option:selected`).val();
    const baseUrl = $("#base-url").data("url");

    const filter = getFilter(type, month);
    console.log(filter);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}reportes/getFilterData`, //getYearFiltered`,
        data:{
            year: year,
            band: band
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) =>{
            const response = JSON.parse(data);
            const charts = type == "total" ? response.chart : getDataFiltered(response.chart, filter);
            const bono = band == "other" ? null : response.bono;
            const datasets = charts.map((arr, index)=> {
                
                return {
                    label: getLabel(arr.name),
                    stack: index,
                    backgroundColor: bgColorChart(arr.name),
                    data: arr.records,
                }
            });

            const montlyRecords = charts.map(arr => arr.records).reduce((acc, curr, idx) => {

                acc[0] += curr[0]; acc[1] += curr[1];
                acc[2] += curr[2]; acc[3] += curr[3];
                acc[4] += curr[4]; acc[5] += curr[5];
                acc[6] += curr[6]; acc[7] += curr[7];
                acc[8] += curr[8]; acc[9] += curr[9];
                acc[10] += curr[10]; acc[11] += curr[11];
                
                return  acc;
            }, [0,0,0,0,0,0,0,0,0,0,0,0])
            
            const remove = removeDataChart(getChart);
            const add = addDataChart(getChart, datasets);
            const paintInTable = paintTable($(`.body-table-past-${getCombos}`), montlyRecords, bono);
        }
    })
});
//----------------------------------------
$(document).on("click", ".filter-present-data", function(){

    const band = $(this).data("filter");
    const getCombos = band == "other" ? `others` : `comission`;
    const getChart = band == "other" ? chart4 : chart2;
    const month = $(`#present-months-${getCombos} option:selected`).val(); 
    const type = $(`#present-montly-type-${getCombos} option:selected`).val();
    const baseUrl = $("#base-url").data("url");
    const filter = getFilter(type, month);
    console.log(filter);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}reportes/getFilterData`,
        data:{
            year: 2021,
            band: band
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) =>{
            const response = JSON.parse(data);
            const charts = type == "total" ? response.chart : getDataFiltered(response.chart, filter);
            const bono = band == "other" ? null : response.bono;
            const datasets = charts.map((arr, index)=> {
                
                return {
                    label: getLabel(arr.name),
                    stack: index,
                    backgroundColor: bgColorChart(arr.name),
                    data: arr.records,
                }
            });

            const montlyRecords = charts.map(arr => arr.records).reduce((acc, curr, idx) => {

                acc[0] += curr[0]; acc[1] += curr[1];
                acc[2] += curr[2]; acc[3] += curr[3];
                acc[4] += curr[4]; acc[5] += curr[5];
                acc[6] += curr[6]; acc[7] += curr[7];
                acc[8] += curr[8]; acc[9] += curr[9];
                acc[10] += curr[10]; acc[11] += curr[11];
                
                return  acc;
            }, [0,0,0,0,0,0,0,0,0,0,0,0])
            
            const remove = removeDataChart(getChart);
            const add = addDataChart(getChart, datasets);
            const paintInTable = paintTable($(`.body-table-present-${getCombos}`), montlyRecords, bono);
        }
    })
});
//----------------------------------------
const getDataFiltered = (data, filter1) => {

    const filtered = data.reduce((acc, curr) => {

        return [
            ...acc, {
                name: curr.name,
                records: curr.records.reduce((acc_, curr_, idx) => { 
                    return [...acc_, (filter1.includes(idx) ? curr_ : 0)] 
                }, []) //filter((arr_, idx) => { return filter1.includes(idx); })
            }
        ]
    }, []);

    //console.log(filtered);

    return filtered;
}
//----------------------------------------
const getFilter = (type, month) => {

    var filter = [];

    if(type == "mensual"){

        filter.push((month - 1));
    } else{
        const final = (month - 1) + 3;
        const months = [0,1,2,3,4,5,6,7,8,9,10,11];
        filter = months.slice((month - 1), final);
    }

    return filter;
}
//----------------------------------------
const paintTable = (element, monthsdata, other = null) => {

    const total = monthsdata.reduce((acc, curr) => acc += `<td>${curr.toLocaleString("en-US")}</td>`, ``);
    const bono = other !== null ? `<tr><td>Bono 2021</td><td>${other}</td><tr>` : ``;

    $(element).html(`${bono}<tr><td><b>Ingresos totales</b></td>${total}</tr>`);
}
//---------------------------------------
/*$(document).on("change", "input[type=radio][name=year-filter-comission]", function(){

    const value = $(this).val();
    const baseUrl = $("#base-url").data("url");
    console.log(value);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}reportes/getYearFiltered`,
        data:{
            year: value
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) =>{
            const response = JSON.parse(data);
            const charts = response.chart;
            const datasets = charts.map((arr, index)=> {
                
                return {
                    label: getLabel(arr.name),
                    stack: index,
                    backgroundColor: bgColorChart(arr.name),
                    data: arr.data,
                }
                
            });

            //console.log(chart1);
            const remove = removeDataChart(chart1);
            const add = addDataChart(chart1, datasets);
            //myChartPresupuestoComisionPasado
        }
    })

});*/
//---------------------------------------
const addDataChart = (chart, data) =>{

    data.map(arr => chart.data.datasets.push(arr));
    chart.update();
}
//-----------------------------------------
const removeDataChart = (ctx) => {

    ctx.data.datasets = [];
    ctx.update();
}
//---------------------------------------
const getLabel = (name) => {

    switch(name){
        case "AsesoresMerida": return "Asesores Merida";
        case "AsesoresCancun": return "Asesores Cancun";
        case "Institucional MID": return "Instituciónal MID";
        case "Institucional CAN": return "Instituciónal CAN";
        case "COSTO": return "Costo Venta";
        case "Gasto de Operacion": return "Gastos Operaciones";
        case "Gasto": return "Gastos Operaciones";
        case "Nomina": return "Nomina";
        case "CCO": return "Costo";
    }
}

//------------------------------------
const bgColorChart = (name) => {

    months = [1,2,3,4,5,6,7,8,9,10,11,12];

    switch(name){
        case "AsesoresMerida": return months.map(arr => "rgba(115, 198, 182, 0.6)");
        case "AsesoresCancun": return months.map(arr => "rgba(127, 179, 213, 0.6)");
        case "Institucional MID": return months.map(arr => "rgba(255, 206, 86, 0.6)");
        case "Institucional CAN": return months.map(arr => "rgba(243, 156, 18, 0.6)");
        case "COSTO": return months.map(arr => "rgba(54, 162, 235, 0.6)");
        case "Gasto de Operacion": return months.map(arr => "rgba(153, 102, 255, 1)");
        case "Gasto": return months.map(arr => "rgba(153, 102, 255, 1)");
        case "Nomina": return months.map(arr => "rgba(210, 180, 222  , 1)"); //rgba(153, 102, 255, 1)
        case "CCO": return months.map(arr => "rgba(153, 102, 255, 1)");
    }
}
