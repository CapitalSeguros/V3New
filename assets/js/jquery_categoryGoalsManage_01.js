$(`a[data-toggle="tab"]`).on("show.bs.tab", function(e){

    var base_url = $(`#base_url`).val();
    var target = e.target;
    var id_ = $(this).attr("aria-controls");

    axios.get(`${base_url}metacomercial/manageChannelGoal`,{
        params:{
            channel: id_
        }
    })
    .then((result) => {
        //console.log(result.status);
        console.log(result.data);
        var res = result.data;
        var parameters = {};
        const annualMonthsData = res.monthsProgress;
        const monthlyData = res.monthProgress;

        for(var a in annualMonthsData){

            //console.log(a);
            var ctCount = $(`#canvas-${a}-${id_}`);
            var labels = annualMonthsData[a].map(arr => arr.name);
            var values = annualMonthsData[a].map(arr => Math.round(arr.progress));
            var i = 255;
            var rgba = `rgba(${Math.round(Math.random() * i)}, ${Math.round(Math.random() * i)}, ${Math.round(Math.random() * i)}, 1)`;
            var divInfoForCount = annualMonthsData[a].map(arr => `<tr><td>${arr.name}</td><td class="text-center">${Math.round(arr.progress).toLocaleString(`en-ES`)}</td></tr>`);
            $(`#month-${a}-${id_}`).html(divInfoForCount);

            parameters = {
                type_: "line",
                container: ctCount,
                label_: labels,
                data_: [{
                    label: `Cantidad de ${(a == "count" ? "pólizas" : "prima")}`,
                    data: values,
                    fill: false,
                    borderColor: rgba,
                    tension: 0.1,
                }]
            }
            
            var canvas = fillCanvas(parameters);
        }

        for(var b in monthlyData){

            var ctCat = $(`#canvas-category-${b}-${id_}`);
            var labels = Object.keys(monthlyData[b]);
            var goalData = Object.values(monthlyData[b]).map(arr => arr.goal);
            var backgroundGoals = goalData.map(arr => `rgba(51, 122, 255, 0.2)`);
            var bordersGoals = goalData.map(arr => `rgba(51, 122, 255)`);
            var backgroundProgress = goalData.map(arr => `rgba(249, 131, 163, 0.2)`);
            var bordersProgress = goalData.map(arr => `rgba(249, 131, 163)`);
            var progressData = Object.values(monthlyData[b]).map(arr => arr.progress);

            //console.log(monthlyData[b]);
            var category = monthlyData[b];
            var aTarget = ``;

            for(var c in category){
                
                aTarget += `
                    <a href="javascript: void(0)" class="list-group-item">
                        <h5>Avance del canal de ${c.toUpperCase()}</h5>
                        <p>La meta asignada para este canal es de <span class="text-info">${Math.round(category[c].goal).toLocaleString("en-ES")} ${(b == "count" ? "pólizas" : "pesos")}</span></p>
                        <p>El evance para este canal es de <span class="text-success">${Math.round(category[c].progress).toLocaleString("en-ES")} ${(b == "count" ? "pólizas" : "pesos")}</span></p>
                    </a>
                `;
            }

            $(`.list-${b}-${id_}`).html(aTarget);
            //console.log(b);

            parameters = {
                type_: "bar",
                container: ctCat,
                label_: labels,
                data_: [{
                    label: `Meta asignada a cantidad de ${(b == "count" ? "pólizas" : "prima")}`,
                    data: goalData,
                    backgroundColor: backgroundGoals,
                    borderColor: bordersGoals,
                    borderWidth: 1,
                },{
                    label: `Avance en cantidad de ${(b == "count" ? "pólizas" : "prima")}`,
                    data: progressData,
                    backgroundColor: backgroundProgress,
                    borderColor:bordersProgress,
                    borderWidth: 1,
                }]
            }

            var canvas = fillCanvas(parameters);
        }
    }).catch((err) => {
        console.log(err);
    });
    //console.log(e.target);
});

function fillCanvas(array){
    
    var myChart = new Chart(array.container, {
        type: array.type_,
        data: {
            labels: array.label_,
            datasets: array.data_,
        }
    });

    return;
}