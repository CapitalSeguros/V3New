
//window.onload = function(){

    //getProspectiveAgentsFunnelData();
//}

function getProspectiveAgentsFunnelData(){

    var selectedIndex_ = document.getElementById("mesAgentes").selectedIndex;
    var monthValue = selectedIndex_.value();

    console.log(monthValue);
}

//-----------------------------------
function executeFilter(){

    //get selected indexs
    var coorSelect = document.getElementById("selectCoordinator").selectedIndex;
    var coorValue = document.getElementById("selectCoordinator").options[coorSelect];
    var monthSelect = document.getElementById("mesAgentes").selectedIndex;
    var monthValue = document.getElementById("mesAgentes").options[monthSelect];
    var base_url = document.getElementById("base_url").getAttribute("data-url");
    var tableContainer = document.getElementsByClassName("progress-content")[0];
    //Async send data from axios
    axios.get(`${base_url}crmproyecto/agentsForFunnel`, {
        params: {
            coor: coorValue.value,
            month: monthValue.value
        }
    }).then((data) => {
        console.log(data);
        var funnel = data.data.funnel;
        var table = data.data.table;

        for(var a in funnel){

            var label = a.replace("_", "-").toLowerCase();
            var values = 0;
            //console.log(label);

            for(var b in funnel[a]){
                values++; 
            }

            if(a == "CONTACTADO"){
                document.getElementsByClassName(label)[1].innerHTML = `<div class="badge badge-success">${values}</div> ${label.replace("-", " ").toUpperCase()}`;
            }else{
                document.getElementsByClassName(label)[0].innerHTML = `<div class="badge badge-success">${values}</div> ${label.replace("-", " ").toUpperCase()}`;
            }
            //console.log(label);
        }

        tableContainer.innerHTML = ``;
        var contentTd = ``;

        for(var b in table){

            //var trContent = table[b].reduce((acc, curr) => acc += `<tr><td>${curr.name}</td><td>${}</td></tr>`, ``);
            var trContent = ``;

            for(var c in table[b]){
                
                trContent += `<tr><td>${table[b][c].name}</td><td>${(b == "ACTUALIZAR" ? `Actualizar en formulario` : table[b][c].date)}</td></tr>`;
            }
            contentTd += `<td class="${b.toLowerCase()}">
                <div class="col-md-12">
                    <h6>${b}</h6>
                </div>
                <div class="col-md-12">
                    <table  class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>${(b != "ACTUALIZAR" ? "Fecha de actualización" : "Pendiente")}</th>
                            </tr>
                        </thead>
                        <tbody>${trContent}</tbody>
                    </table>
                </div>
            </td>`;
        }

        tableContainer.innerHTML += `
            <h6>Progreso de los agentes en prospección</h6>
            <table>
                <tr>${contentTd}</tr>
            </table>
        `;
        //tableContainer

    }).catch((error) => {
        console.log(error);
    });

    console.log(coorValue.value, monthValue.value);
}
//-----------------------------------
