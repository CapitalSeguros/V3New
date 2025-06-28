//Use vanilla javascript
function getProspectiveData(){
    //console.log("prospecto agente");
    var prospectiveInput = document.getElementById(`prospectiveAgent`);

    if(document.body.contains(prospectiveInput)){

        var base_url = prospectiveInput.getAttribute(`data-baseUrl`);
        //console.log(base_url);
        axios.get(`${base_url}persona/getProspectiveData`, {
            params: {
                id: prospectiveInput.value
            }
        }).
        then(function(response){
            
            const data_ = response.data[0];
            console.log(response.data);
            for(var a in data_){
                
                if(data_[a] !== null){
                    //if(typeof data_[a] === "object"){
                      //  document.getElementById(a).innerHTML = `<option value="${data_[a].value}">${data_[a].label}</option>`;
    
                    //} else{
                        //if(a == "fecAltaSistemPersona"){
                            //document.getElementById(a).value = data_[a].replace("-", "/");
                        //}
                        if(a == "usuarioPersona"){
                            document.getElementById("divUsuarioPersona").innerHTML = `<input class="formEnviar" style="width: 300px" type="text" id="${a}" name="${a}" value="${data_[a]}">`;
                        } else if(a == "usuarioPassword"){
                            document.getElementById("divPasswordPersona").innerHTML = `<input class="formEnviar" style="width: 300px" type="text" id="${a}" name="${a}" value="${data_[a]}">`;
                        } else{
                             //else{
                                document.getElementById(a).value = (a == "fecAltaSistemPersona" ? data_[a].replace("-", "/").replace("-", "/") :  data_[a]);
                            //}
                        }
                    //}
                }
            }

        }).
        catch(function (error) {
            console.log(error);
        })
    } else{
        console.log(`No existe el elemento`);
    }
}

window.onload = function(){

    getProspectiveData();
}