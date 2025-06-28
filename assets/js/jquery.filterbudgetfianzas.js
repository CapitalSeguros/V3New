$(document).on("click", ".filter-past-data-fianzas", function(){

    const band = $(this).data("filter");
    const getCombos = band == "other-fianzas" ? `others` : `comission`;
    const getChart = band == "other-fianzas" ? chartf3 : chartf1;
    const year = $(`#past-years-${getCombos}-fianzas option:selected`).val();
    const month = $(`#past-months-${getCombos}-fianzas option:selected`).val(); //past-months-comission //past-montly-type-comission
    const type = $(`#past-montly-type-${getCombos}-fianzas option:selected`).val();
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
            const datasets = charts.map((arr, index)=> {
                
                return {
                    label: band == "other-fianzas" ? getLabel(arr.name) : arr.name,
                    stack: index,
                    backgroundColor: band == "other-fianzas" ? bgColorChart(arr.name) : bgColorChartFianzas(arr.name),
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
            const paintInTable = paintTable($(`.body-table-past-${getCombos}-fianzas`), montlyRecords, null);
        }
    })
});

//---------------------------------------
$(document).on("click", ".filter-present-data-fianzas", function(){

    const band = $(this).data("filter");
    const getCombos = band == "other-fianzas" ? `others` : `comission`;
    const getChart = band == "other-fianzas" ? chartf4 : chartf2;
    const month = $(`#present-months-${getCombos}-fianzas option:selected`).val(); //past-months-comission //past-montly-type-comission
    const type = $(`#present-montly-type-${getCombos}-fianzas option:selected`).val();
    const baseUrl = $("#base-url").data("url");

    const filter = getFilter(type, month);
    console.log(filter);

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}reportes/getFilterData`, //getYearFiltered`,
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
            const datasets = charts.map((arr, index)=> {
                
                return {
                    label: band == "other-fianzas" ? getLabel(arr.name) : arr.name,//arr.name,
                    stack: index,
                    backgroundColor: band == "other-fianzas" ? bgColorChart(arr.name) : bgColorChartFianzas(arr.name), //bgColorChartFianzas(arr.name),
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
            const paintInTable = paintTable($(`.body-table-present-${getCombos}-fianzas`), montlyRecords, null);
        }
    })
});
//---------------------------------------
const getLabelFianzas = (name) => {

    switch(name){
        case "AsesoresMerida": return "Asesores Merida";
        case "AsesoresCancun": return "Asesores Cancun";
        case "Institucional MID": return "Instituciónal MID";
        case "Institucional CAN": return "Instituciónal CAN";
    }
}

//------------------------------------
const bgColorChartFianzas = (name) => {

    months = [1,2,3,4,5,6,7,8,9,10,11,12];

    switch(name){
        case "Institucional": return months.map(arr => "rgba(115, 198, 182, 0.6)");
        case "Coporativa": return months.map(arr => "rgba(127, 179, 213, 0.6)");
        case "Asesores": return months.map(arr => "rgba(255, 206, 86, 0.6)");
    }
}
//--------------------------------