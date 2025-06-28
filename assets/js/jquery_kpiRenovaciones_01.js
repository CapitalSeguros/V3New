$(function (){

    window.setInterval(getRenovations, 5*60*1000); //interval of 10 minutes for update renovation content.
    getRenovations(); //load page.
});

function getRenovations(){
    
    var baseUrl = $("#base_url").data("base-url");
    //alert("Hola mundo");
    //if($("#divRenovaciones").length > 0){
        //console.log("Hola mundo");

        $.ajax({
            type: `GET`,
            url: `${baseUrl}renovaciones/getRenewedRenewals`,
            error: function(error){
                console.log(error);
            },
            success: function(response){

                var resp = JSON.parse(response);
                console.log(resp);
                if(Object.keys(resp).length > 0){

                    //console.log(Object.values(resp));
                    var totalGreen = Object.values(resp).reduce((acc, curr) => acc += curr.green, 0);
                    var totalYellow = Object.values(resp).reduce((acc, curr) => acc += curr.yellow, 0);
                    var totalRed = Object.values(resp).reduce((acc, curr) => acc += curr.red, 0);

                    $(`.total-green`).html(totalGreen);
                    $(`.total-yellow`).html(totalYellow);
                    $(`.total-red`).html(totalRed);
                    $(`.total-rewals`).html(totalGreen + totalYellow + totalRed);
                    
                    for(var a in resp){

                        var classFather = a.replace(" ", "-").replace("daños", "danios");
                        var total = Object.values(resp[a]).reduce((acc, curr) => acc += curr, 0);
                        $(`.${classFather}-total`).html(total);

                        for(var b in resp[a]){

                            var _class = `${classFather}-${b}-yr`;
                            $(`.${_class}`).html(`<b>${resp[a][b]}</b>`);
                        }
                    }
                }
            }
        });

    //}
}