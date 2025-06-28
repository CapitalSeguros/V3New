$(function(){
    window.setInterval(getActivities, 5*60*1000); //interval of 10 minutes for update renovation content.
    getActivities(); //load page.
});

const getActivities = () => {

    const baseUrl = $("#base_url").data("base-url");

    if($(".muestra_avance_operativo").length == 0){

        console.log("No se detectó el kpi de actividades");
        return false;
    }

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}actividades/getActivitiesKpi`,
        error: (error, textStatus, errorMesage) => {
            //alert(textStatus);
            console.log(error, textStatus, errorMesage);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            const kpi = response.data;
            for(const a in kpi){ //a is category
                for(const b in kpi[a]){ //b is sub-category
                    for(const c in kpi[a][b]){ //c is colour

                        $(`.${a}-${b}-${c}`).html(`<b>${kpi[a][b][c]}</b>`);
                    }
                }
            }
        }
    });
}