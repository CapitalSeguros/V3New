//Recorrido de los elementos form de la tabla.

var formulario=document.getElementById("formCaracteristicas");
var url=window.location.href.replace("agentesEnProceso","");
//console.log(url);

for(var i=0; i<formulario.elements.length; i++){
    //console.log(formulario.elements[i].name);
    if(formulario.elements[i].type=="checkbox" && formulario.elements[i].checked){
        var idPersona=formulario.elements[i].getAttribute("data-idpersona");
        var caracteristica=formulario.elements[i].getAttribute("data-idtipoobservacion");

        var ul=document.getElementById("list_"+idPersona);

        if(caracteristica!="miinfo"){
            //console.log(li);
            //ul.innerHTML=``;
            //<i class="fa fa-clipboard" aria-hidden="true"></i>
            //<li class="divider"></li> funciona como hr
            ul.innerHTML+=`
                <li id='li_`+idPersona+`_`+caracteristica+`' data-idPersona="`+idPersona+`" data-caracteristica="`+caracteristica+`" onclick="solicitarEvaluacion(this);">
                    <a>`+caracteristica.replace("manualagente","Manual agente").replace("induccionempresa","Inducción empresa").replace("agenteideal","Agente ideal").replace("capacitacionsistema","Capacitación sistema").toUpperCase()+`</a>
                </li>
            `;
        }
    }
} 

//console.log(contador);
//Función que realiza una petición AJAX para envío de correos.
function solicitarEvaluacion(objetoHTML){

    //console.log(objetoHTML);
    var idPersona=objetoHTML.getAttribute("data-idPersona");
    var caracteristicaEvaluacion=objetoHTML.getAttribute("data-caracteristica");

    //console.log(idPersona,caracteristicaEvaluacion);

    //Envio de solicitud por XMLHTTPREQUEST

    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            //console.log(this.responseText);
            //console.log(JSON.parse(this.responseText));
            var respuesta=JSON.parse(this.responseText);

            alert(respuesta.mensaje);
        }
    }

    if(confirm("Está seguro de enviar la solicitud de evaluación del tema: "+caracteristicaEvaluacion.replace("manualagente","Manual agente").replace("induccionempresa","Inducción empresa").replace("agenteideal","Agente ideal").replace("capacitacionsistema","Capacitación sistema"))){
        xmlhttp.open("GET",url+"enviarSolicitudEvaluacion?q="+idPersona+"&r="+caracteristicaEvaluacion.replace("manualagente","Manual agente").replace("induccionempresa","Inducción empresa").replace("agenteideal","Agente ideal").replace("capacitacionsistema","Capacitación sistema"),true);
        xmlhttp.send();
    }
}