//console.log("Hola mundo");

//Eliminar el flotante de KPI Comercial al cargar la página de cobranza.
$(function(){

    //$( "#flotante_avance_cobranza" ).draggable(); //Efecto de div arrastable.

    //var div_flotante=document.getElementById("seguimientoSicas");
    //var padre=div_flotante.parentNode;

    //padre.removeChild(div_flotante); //Eliminación del div de comisiones.

}); 

//Minimizar y maximizar ventana flotante.
function maximina_minimiza_ventana(DomElement){

    var contenedor_info_avance_cobranza=document.getElementsByClassName("contenedor_avance_cobranza")[0];
    var band=DomElement.getAttribute("id_band");
    var _caret=document.getElementsByClassName("dd_caret")[0];

    if(band==0){
        contenedor_info_avance_cobranza.style.display="none";
        _caret.classList.replace("fa-sort-desc","fa-sort-asc");
        DomElement.setAttribute("id_band",1);
    } else{
        contenedor_info_avance_cobranza.style.display="block";
        _caret.classList.replace("fa-sort-asc","fa-sort-desc");
        DomElement.setAttribute("id_band",0);
    }
    //console.log(band);
}

function despliega_informacion(DomElement){

    var band=DomElement.getAttribute("id_band_son");
    var hijos_element=DomElement.childNodes;

    for(var i=0; i<hijos_element.length; i++){

        //console.log(hijos_element[i]);
        if(band==0 && hijos_element[i]!=DomElement.firstChild){
            hijos_element[i].style.display="block";
            DomElement.setAttribute("id_band_son",1);

        } else if(band==1 && hijos_element[i]!=DomElement.firstChild){
            hijos_element[i].style.display="none";
            DomElement.setAttribute("id_band_son",0);
        }
    }
}
