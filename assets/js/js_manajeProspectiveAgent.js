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
            document.getElementById("labelEstadoPersona").innerHTML = `${data_.nombres} ${data_.apellidoPaterno} ${data_.apellidoMaterno} - PROSPECTO AGENTE`
            document.getElementsByClassName("job-person")[0].style.display = "none";

            //----------------------- //Show agents options
            var _elements = document.getElementsByClassName("agent-person");

            for(var cc in _elements){

                var child = _elements[cc].childNodes;

                for(var dd in child){

                    if(child[dd].tagName === "BUTTON"){
                        child[dd].click();
                        //console.log(child[dd]);
                    }
                }
            }
            //-----------------------

            for(var a in data_){
                
                if(data_[a] !== null){
                    
                        if(a == "usuarioPersona"){

                            document.getElementById("divUsuarioPersona").innerHTML = `<input class="formEnviar" style="width: 300px" type="text" id="${a}" name="${a}" value="${data_[a]}">`;
                        } else if(a == "usuarioPassword"){

                            document.getElementById("divPasswordPersona").innerHTML = `<input class="formEnviar" style="width: 300px" type="text" id="${a}" name="${a}" value="${data_[a]}">`;
                        }  else if(a == "tipoPersona"){

                            document.getElementById("tipoPersona").innerHTML = `<option value="${data_[a]}">Agente</option>`;
                        }
                        else if(a == "idColaboradorArea"){

                            document.getElementById("idColaboradorArea").innerHTML = `<option value="${data_[a]}">Comercial</option>`;
                        }
                        else{
                            document.getElementById(a).value = (a == "fecAltaSistemPersona" ? data_[a].replace("-", "/").replace("-", "/") :  data_[a]);
                        }
                }
            }

            showOptionsPerson(2);
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