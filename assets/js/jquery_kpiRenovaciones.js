$(function (){

    window.setInterval(getRenovations, 5*60*1000); //interval of 10 minutes for update renovation content.
    getRenovations(); //load page.
});

function getRenovations(){
    
    var baseUrl = $("#base_url").data("base-url");

    if($(".muestra_avance_operativo").length > 0){ //muestra_avance_operativo
        $.ajax({
            type: `GET`,
            url: `${baseUrl}renovaciones/getRenovationsKpi`, //getRenewedRenewals
            error: function(error){
                console.log(error);
            },
            success: function(response){

                const data = JSON.parse(response);
                console.log(data);

                for(const a in data){

                    var totalGreen = Object.values(data[a].content).reduce((acc, curr) => acc += curr.green, 0);
                    var totalYellow = Object.values(data[a].content).reduce((acc, curr) => acc += curr.yellow, 0);
                    var totalRed = Object.values(data[a].content).reduce((acc, curr) => acc += curr.red, 0);
                    const categories = data[a].content;

                    $(`.total-${data[a].class}-green`).html(totalGreen);
                    $(`.total-${data[a].class}-yellow`).html(totalYellow);
                    $(`.total-${data[a].class}-red`).html(totalRed);
                    $(`.total-${data[a].class}`).html(`<b>${(totalGreen + totalYellow + totalRed)}</b>`)
                    
                    for(const b in categories){

                        const colours = categories[b];
                        const classFather = b.replace(" ", "-").replace("daños", "danios");
                        const total = Object.values(categories[b]).reduce((acc, curr) => acc += curr, 0);
                        $(`.${data[a].class}-${classFather}-total`).html(total);
                        
                        for(const c in colours){

                            const class_ = `${data[a].class}-${classFather}-${c}-yr`;
                            $(`.${class_}`).html(`<b>${colours[c]}</b>`);
                        }
                    }
                }
            }
        });
    }
}