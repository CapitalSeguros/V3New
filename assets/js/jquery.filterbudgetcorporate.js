$(document).on("click", ".filter-past-data-corporate", function(){

    const band = $(this).data("filter");
    const getCombos = band == "other-corporate" ? `others` : `comission`;
    const getChart = band == "other-corporate" ? chartc3 : chartc1;
    const year = $(`#past-years-${getCombos}-corporate option:selected`).val();
    const month = $(`#past-months-${getCombos}-corporate option:selected`).val();
    const type = $(`#past-montly-type-${getCombos}-corporate option:selected`).val();
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
                    label: band == "other-corporate" ? getLabel(arr.name) : arr.name,
                    stack: index,
                    backgroundColor: band == "other-corporate" ? bgColorChart(arr.name) : bgColorChartFianzas(arr.name),
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
            
            console.log(datasets);

            const remove = removeDataChart(getChart);
            const add = addDataChart(getChart, datasets);
            const paintInTable = paintTable($(`.body-table-past-${getCombos}-corporate`), montlyRecords, null);
        }
    })
});

//-----------------------------
$(document).on("click", ".filter-present-data-corporate", function(){

    const band = $(this).data("filter");
    const getCombos = band == "other-corporate" ? `others` : `comission`;
    const getChart = band == "other-corporate" ? chartc4 : chartc2;
    const year = $(`#present-years-${getCombos}-corporate option:selected`).val();
    const month = $(`#present-months-${getCombos}-corporate option:selected`).val();
    const type = $(`#present-montly-type-${getCombos}-corporate option:selected`).val();
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
                    label: band == "other-corporate" ? getLabel(arr.name) : arr.name,
                    stack: index,
                    backgroundColor: band == "other-corporate" ? bgColorChart(arr.name) : bgColorChartFianzas(arr.name),
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
            
            console.log(datasets);

            const remove = removeDataChart(getChart);
            const add = addDataChart(getChart, datasets);
            const paintInTable = paintTable($(`.body-table-present-${getCombos}-corporate`), montlyRecords, null);
        }
    })
});