
//Link de consulta: https://www.w3schools.com/howto/howto_js_draggable.asp

$(function(){

    var div_flotante_principal=document.getElementById("flotante_contenedor");

    //console.log(document.getElementById("flotante_contenedor"));
    
    if(document.body.contains(div_flotante_principal)){
        elementoArrastrable(div_flotante_principal);
    }

});

function elementoArrastrable(elementoHTML){

    var p1=0;
    var p2=0;
    var p3=0;
    var p4=0;

    //cabecera_ft=document.getElementsByClassName(elementoHTML+"cabecera")[0];
    /*if(document.getElementById(elementoHTML.id+"_cabecera")){
        document.getElementById(elementoHTML.id+"_cabecera").onmousedown=accionArrastrar;
    } else{
        elementoHTML.onmousedown=accionArrastrar;
    }*/
    elementoHTML.onmousedown=accionArrastrar;
//}
    function accionArrastrar(e){
        //console.log("Holaaaa");
        e=e || window.event;
        e.preventDefault()
        p3=e.clientX;
        p4=e.clientY;

        //console.log(e);
        document.onmouseup=detieneEventoArrastre;
        document.onmousemove=activaEventoArrastre;

    }

    function detieneEventoArrastre(){
        console.log("Evento cerrado");
        document.onmouseup = null;
        document.onmousemove = null;
    }

    function activaEventoArrastre(e){
        //console.log()
        e=e || window.event;
        e.preventDefault()
        //console.log(p3,p4);
        p1 = p3 - e.clientX;
        p2 = p4 - e.clientY;
        p3 = e.clientX;
        p4 = e.clientY;

        //console.log(elementoHTML);
        elementoHTML.style.top=(elementoHTML.offsetTop-p2)+"px";
        elementoHTML.style.left=(elementoHTML.offsetLeft-p1)+"px";
    }
}