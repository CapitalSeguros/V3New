$(function(){

    getGoals();
});

function getGoals(){

    const base_url = document.getElementById("base").value;
    //console.log(base_url);
    axios.get(`${base_url}reportes/getGoals`)
    .then(function(response){

        console.log(response.data);

        var superCanvas = document.getElementsByClassName("body-goal")[0];

        response.data.map((arr, i) => {

            var div = document.createElement("div");
            var canvas = document.createElement("canvas");
            canvas.id = arr.label.toLowerCase().replace("ó", "o");
            canvas.height = "600";
            div.setAttribute("class", "col-md-4");
            div.appendChild(canvas);
            superCanvas.appendChild(div);

            var ctx = document.getElementById(arr.label.toLowerCase().replace("ó", "o")).getContext("2d");
            
            var typeResult = arr.label == "Pólizas" ? "recibos" : "MXN";

            var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: [arr.label],
                    datasets: [{
                        label: `${arr.label}`,
                        data: [Math.round(arr.value)],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    })
    .catch(function(error){
        console.log(error);
    });

}