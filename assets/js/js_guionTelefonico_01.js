contador = 1;

function crearBloqueConversacion(){
    //console.log("hola mundo");

    var div = document.createElement("div");
    div.setAttribute("class","mt-4");
    
    var divEtiqueta = document.createElement("div");
    //divEtiqueta.setAttribute("class","col-md-4");

    var entradaEtiqueta = document.createElement("input");
    entradaEtiqueta.setAttribute("class","form-control");
    entradaEtiqueta.setAttribute("placeholder","nombre de la etiqueta");
    //entradaEtiqueta.setAttribute("required");
    //entradaEtiqueta.style.width = "200px";
    entradaEtiqueta.id = "etiqueta_"+contador;

    var botonEliminar = document.createElement("button");
    botonEliminar.setAttribute("class","btn btn-danger btn-sm eliminaBloque");
    botonEliminar.textContent = "Eliminar bloque";
    //botonEliminar.onclick = eliminaBloque();
    botonEliminar.setAttribute("onclick", "eliminaBloque(this)");

    var agrupador = document.createElement("div");
    agrupador.setAttribute("class","form-group row");
    
    var divInput = document.createElement("div");
    divInput.setAttribute("class","col-md-4");

    var divDelete = document.createElement("div");
    divDelete.setAttribute("class","col-md-2");

    var entradaTexto = document.createElement("textarea");
    entradaTexto.name="textoGuion";
    entradaTexto.id="textoGuion";
    entradaTexto.cols = "90";
    entradaTexto.rows = "5";
    entradaTexto.id = "texto_"+contador;
    //entradaTexto.setAttribute("required");

    var divisor = document.createElement("hr");
    divisor.setAttribute("class", "mt-4")

    divInput.appendChild(entradaEtiqueta);
    divDelete.appendChild(botonEliminar);

    agrupador.appendChild(divInput);
    agrupador.appendChild(divDelete);
    //agrupador.appendChild(botonEliminar);
    //divEtiqueta.appendChild(agrupador);
    //divEtiqueta.appendChild(entradaTexto);
    div.appendChild(agrupador);
    div.appendChild(entradaTexto);

    //div.appendChild(divEtiqueta);
    div.appendChild(divisor);

    document.getElementById("cont_creacion").appendChild(div);
    //document.getElementById("cont_creacion").appendChild(divisor);
    contador++;
}

document.getElementById("crear_guion").addEventListener("click", crearBloqueConversacion);
//--------------------------------
function eliminaBloque(element){

    var padre = element.parentNode.parentNode.parentNode;
    var contenedor = padre.parentNode;
    contenedor.removeChild(padre);
}
//--------------------------------
function registraGuionTelefonico(e){

    var actualiza_guion = e.target.getAttribute("data-guion");
    var actualiza_modulo = e.target.getAttribute("data-modulo");
    var selectIndex = document.getElementById("modulo").selectedIndex;
    var modulo = document.getElementById("modulo").options[selectIndex].value;
    var nombreGuion = document.getElementById("nombreGuion").value;
    var direccion = window.location.href;//.replace("permisosOperativos",""); //gestionGuionTelefonico
    var mensajes = [];
    var formulario = document.getElementById("cont_creacion");

    //console.log(actualiza_guion, actualiza_modulo);

    if(nombreGuion == "" || modulo == 0){

        alert("No se seleccionó una opción del combo o no se asignó un nombre al guión");
        return false;
    } else if(formulario.elements.length == 0){
        alert("No se detectaron bloques para el guión");
        return false;
    }

    //agrupación
    var json_send = {};
    json_send["modulo"] = modulo;
    json_send["nombreGuion"] = nombreGuion;
    json_send["actualiza_modulo"] = actualiza_modulo;
    json_send["actualiza_guion"] = actualiza_guion;


    for(var a = 0; a<formulario.elements.length; a++){

        var msg = {};
        var elementoHTML = formulario.elements[a].type;
        var elementosAdmitidos = ["text"];

        if(elementosAdmitidos.includes(elementoHTML)){

            var id = formulario.elements[a].id.split("_");

            if(formulario.elements[a].value == "" || document.getElementById("texto_"+id[1]).value == ""){

                alert("Un campo de los bloques esta vacio. Revisar");
                return false;
            }
            //console.log(id);
            msg["etiqueta"] = elementoHTML == "text" ? formulario.elements[a].value : "";
            msg["mensaje"] = document.getElementById("texto_"+id[1]).value.replace(/\n/g, '<br />');

            mensajes.push(msg);
        }
    }

    json_send["mensajes"] = mensajes;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            var res = JSON.parse(this.responseText);
            //console.log(res);
            window.location.reload();
        }
    }
    xmlhttp.open("POST", direccion+"/registraGuionTelefonico", true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("sendData="+JSON.stringify(json_send));
}

document.getElementById("enviaDatos").addEventListener("click",registraGuionTelefonico);
//------------------------------------
function eliminarGuion(elemento){

    var modulo = elemento.getAttribute("data-modulo");
    var guion =  elemento.getAttribute("data-guion");
    var direccion = window.location.href; //.replace("permisosOperativos","");

    //$this->db->affected_rows()
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            var res = JSON.parse(this.responseText);
            //console.log(res);

            if(res.bool){

                var hijo = document.getElementsByClassName("gc-"+guion)[0].parentNode;
                var padre = hijo.parentNode;
                //console.log(padre);
                padre.removeChild(hijo);
            }

        }
    }

    xmlhttp.open("GET", direccion+"/eliminaRegistroDeGuion?q="+guion, true);
    xmlhttp.send();
    //console.log(modulo);
}
//-------------------------------------
function editarGuion(elemento){

    var modulo = elemento.getAttribute("data-modulo");
    var guion = elemento.getAttribute("data-guion");
    var direccion = window.location.href; //.replace("gestionGuionTelefonico","");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            var res = JSON.parse(this.responseText);
            //console.log(res);

            document.getElementById("modulo").value = res.idModulo;
            document.getElementById("nombreGuion").value = res.nombre;
            document.getElementById("enviaDatos").setAttribute("data-modulo", res.idModulo);
            document.getElementById("enviaDatos").setAttribute("data-guion", res.idNombre);
            document.getElementById("enviaDatos").innerHTML = "Actualizar guion telefónico";
            document.getElementById("create").classList.add("active"); //guion_lista
            document.getElementById("guion_lista").classList.remove("active");
            document.getElementById("cont_creacion").innerHTML = "";
            contador = 0;

            for(var a in res.mensaje){

                document.getElementById("cont_creacion").innerHTML += `
                    <div class="mt-4">
                        <!--<div>-->
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <input class="form-control" placeholder="nombre de la etiqueta" id="etiqueta_${contador}" value="${res.mensaje[a].etiqueta}">
                                </div>
                                <div class="col-md-2">
                                        <button class="btn btn-danger btn-sm eliminaBloque" onclick="eliminaBloque(this)">Eliminar bloque</button>
                                </div>
                            </div>
                             <textarea name="textoGuion" id="texto_${contador}" cols="90" rows="5">${res.mensaje[a].texto.replace("<br />", "\n")}</textarea>
                        <!--</div>-->
                    </div>
                `;

                    contador++;
                }
        }
    }

    xmlhttp.open("GET", direccion+"/devuelveDatosGuion?q="+modulo+"&r="+guion, true);
    xmlhttp.send();
}
//---------------------------------------
//document.getElementsByClassName("eliminarGuion").addEventListener("click",eliminarGuion);
