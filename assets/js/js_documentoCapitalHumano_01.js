function muestraOpcion(id,permiso){

    if(permiso==1){
        document.getElementById("eliminar_doc_"+id).style.display="inline-block";
    } 
  
}
  
function ocultarOpcion(id,permiso){

    if(permiso==1){
        document.getElementById("eliminar_doc_"+id).style.display="none";
    }
}
  
function eliminarArchivo(id){
    //console.log("Hola");

    //console.log(window.location.href.replace("capitalHumano",""));
    var url=window.location.href.replace("capitalHumano","");
    //Conexión a XMLHTTPREQUEST
    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){

        if(this.readyState==4 && this.status==200){
            //console.log(this.responseText);

            var respuesta=JSON.parse(this.responseText);

            alert(respuesta.mensaje);

            if(respuesta.bool){
                window.location.reload();
            }
        }
    }

    xmlhttp.open("GET",url+"capitalHumano/eliminar_documento?q="+id,true);
    xmlhttp.send();
}