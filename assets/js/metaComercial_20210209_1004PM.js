//console.log("Hola");

var selectMCA=document.getElementById("listaActividades");
var selectCoordinacion=document.getElementById("coordinacionId");
var contenedorMA=document.getElementById("contenidoMF");
var entradaMonto=document.getElementById("cantidadAnual");
var botonSubmit=document.getElementById("btnSubmit");
var botonSubmitMensual=document.getElementById("submitMontoMensual");
var contenedorAsignados=document.getElementById("contAsignados");
var idMetaC=document.getElementById("idMetaC");
var ultimoId=0;
var contenedorPrima=document.getElementById("contenedor_asignacion_prima"); //metaPC

selectMCA.addEventListener("change",function(){

    if(selectMCA.value=="metaCA"){

        contenedorMA.style.display="inline-block";
        contenedorAsignados.style.display="none";
        selectCoordinacion.value=0;
        entradaMonto.value="";
        idMetaC.value=0;
    } else if(selectMCA.value=="listAsigna"){

        //console.log("aqui");

        contenedorAsignados.style.display="inline-block";
        contenedorMA.style.display="none";
    }
    else if(selectMCA.value=="metaPC"){

        //console.log("aqui");

        contenedorPrima.style.display="inline-block";
        contenedorMA.style.display="none";
        contenedorAsignados.style.display="none";
    }
});

console.log(window.location.href);
var direccion=window.location.href;
//--------------------------------------------------------------------------------
//ID: cantidadAnual

var input_monto_anual=document.getElementById("cantidadAnual");
input_monto_anual.addEventListener("keyup", function(e){

    //document.getElementById("monto_en_miles").innerHTML=e.target.value.replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ","); //Intl.NumberFormat().format(e.target.value); //e.target.value;
    document.getElementById("monto_en_miles").innerHTML=Intl.NumberFormat().format(e.target.value); //e.target.value;
    //replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");

});
//--------------------------------------------------------------------------------
function enviaMetaComercial() {
    
    var xmlhhtp=new XMLHttpRequest();

    var mensual={};
    mensual[1]="ENERO";
    mensual[2]="FEBRERO";
    mensual[3]="MARZO";
    mensual[4]="ABRIL";
    mensual[5]="MAYO";
    mensual[6]="JUNIO";
    mensual[7]="JULIO";
    mensual[8]="AGOSTO";
    mensual[9]="SEPTIEMBRE";
    mensual[10]="OCTUBRE";
    mensual[11]="NOVIEMBRE";
    mensual[12]="DICIEMBRE";
    
    var mes=[1,2,3,4,5,6,7,8,9,10,11,12];

    if(selectCoordinacion.value==0 || entradaMonto.value==0){
        alert("No se seleccionó a un coordinador o no se asignó una cantidad");
    } else{
        //console.log("aqui");
        xmlhhtp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(JSON.parse(this.responseText));
                console.log(JSON.parse(this.responseText).length);
                //console.log("hola");
                //console.log(this.responseText);

                //alert("Meta global asignado, favor de asignar montos mensuales en la parte de abajo");

                resp=JSON.parse(this.responseText);

                if(resp.length>0 && idMetaC.value==0){

                    alert("Meta global asignado, favor de asignar montos mensuales en la parte de abajo");

                    ultimoId=resp[0];

                    document.getElementById("conttablaMensual").style.display="inline-block";
                    document.getElementById("metaAsig").innerHTML="Meta anual asignado: $"+new Intl.NumberFormat().format(entradaMonto.value)+" MXN";
        
                    var contenedorTabla=document.getElementById("cuerpoMM");
    
                    contenedorTabla.innerHTML="";
    
                    for(var i=0; i<mes.length; i++){
                        contenedorTabla.innerHTML+=`
                            <tr>
                                <td>`+mensual[mes[i]]+`</td>
                                <td class="text-left"><input type="number" name="`+mes[i]+`" class="form-control" id="mes_`+mes[i]+`" required></td>
                                <td id="MontoRestante_`+i+`"></td>
                            </tr>
                        `;
                    }
                } else if((resp.length>0 || resp.length==0) && idMetaC.value>0){

                    alert("Meta global asignado, favor de asignar montos mensuales en la parte de abajo");
                    
                    ultimoId=idMetaC.value

                    document.getElementById("conttablaMensual").style.display="inline-block";
                    document.getElementById("metaAsig").innerHTML="Meta anual asignado: $"+new Intl.NumberFormat().format(entradaMonto.value)+" MXN";
        
                    var contenedorTabla=document.getElementById("cuerpoMM");
    
                    contenedorTabla.innerHTML="";

                    var respuesta=JSON.parse(this.responseText);

                    var valida=[];

                    for(var i=0; i<mes.length; i++){

                        if(respuesta.length>0){

                            for(var index in respuesta){
                                if(mes[i]==respuesta[index].mes_num){
                                    contenedorTabla.innerHTML+=`
                                        <tr>
                                            <td>`+mensual[mes[i]]+`</td>
                                            <td class="text-left"><input type="number" name="`+mes[i]+`" class="form-control" id="mes_`+mes[i]+`" value="`+respuesta[index].monto_al_mes+`" required></td>
                                        </tr>
                                    `;
                                    //valida.push(respuesta[index].mes_num);
                                }
                            }
                        //
                        } else{
                            contenedorTabla.innerHTML+=`
                                        <tr>
                                            <td>`+mensual[mes[i]]+`</td>
                                            <td class="text-left"><input type="number" name="`+mes[i]+`" class="form-control" id="mes_`+mes[i]+`" required></td>
                                        </tr>
                                    `;
                        }
                    }
                } else if(resp.length==0){
                    alert("La asignación al coordinador ya esta registrado, si desea cambiar el monto del coordinador por favor seleccione la opcion: Ver lista de asignados");
                }
            }
        }
    
        //xmlhhtp.open("POST",direccion+"almacenaMetaComercial",true);
        //xmlhhtp.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' ); 
        xmlhhtp.open("GET",direccion+"/almacenaMetaComercial?q="+selectCoordinacion.value+"&r="+entradaMonto.value+"&p="+idMetaC.value, true);
        xmlhhtp.send();
    }    
}
//-------------------------------------------------------------------------------------------------
function enviaMontosMensuales(e){

    e.preventDefault();

    var formulario=document.getElementById("formMensualM");

    var datos={};

    var conteo=0;
    var camposllenos=0;

    for(var i=0;i<formulario.elements.length;i++){
       //console.log(formulario.elements[i]);
       if(formulario.elements[i].type=="number"){
            datos[formulario.elements[i].name]=formulario.elements[i].value;
        
            if(formulario.elements[i].value!=""){
                conteo+=parseFloat(formulario.elements[i].value);
                camposllenos++;
            }
        }
    }

    console.log(conteo);

    if(conteo>entradaMonto.value){
        alert("Se rebasó la cantidad anual");
        formulario.reset();
        selectCoordinacion.value=0;
        //entradaMonto.value="";
        conteo=0;
    } else if(camposllenos<12){
        alert("Dejó un campo vacío, revise de nuevo");
        //formulario.reset();
        selectCoordinacion.value=0;
    } else{
        
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(this.responseText);

                if(this.responseText==true){

                    alert("Datos enviados");

                    formulario.reset();
                    selectCoordinacion.value=0;
                    entradaMonto.value="";
                    //idMetaC.value=0;
                    document.location.reload();
                }
            }
        }

        xmlhttp.open("GET",direccion+"almacenaMontosMensuales?q="+ultimoId+"&r="+JSON.stringify(datos)+"&p="+idMetaC.value,true);
        xmlhttp.send();
    }
    
}
//-------------------------------------------------------------------------------------------------------------
function eliminaMeta(idMeta){

    var xmlhttp=new XMLHttpRequest();

    if(idMeta<0){
        alert("Ocurrió un error al eliminar, por favor contacte al departamento de sistemas");
    } else{

        xmlhttp.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                console.log(JSON.parse(this.responseText));

                var respuesta=JSON.parse(this.responseText);

                for(var indice in respuesta){
                    
                    alert(respuesta[indice].mensaje);

                    if(respuesta[indice].proceso){
                        var fila=document.getElementById("fila_"+idMeta);
                        fila.style.display="none"
                    }

                }
            }
        }

        xmlhttp.open("GET", direccion+"eliminaMetaAsignado?q="+idMeta,true);
        xmlhttp.send();
    }

}
//-----------------------------------------------------------------------------------
function actualizaMeta(idPersona,montoAnual,idMeta){
    
    contenedorMA.style.display="block";
    contenedorAsignados.style.display="none";

    selectCoordinacion.value=idPersona;
    entradaMonto.value=montoAnual;
    idMetaC.value=idMeta;

    botonSubmit.innerHTML="Actualizar meta comercial";

}
//-----------------------------------------------------------------------------------
botonSubmit.addEventListener("click",enviaMetaComercial);
botonSubmitMensual.addEventListener("click",enviaMontosMensuales);
//-----------------------------------------------------------------------------------

var contenedor_personal=document.getElementById("contenedor_personal");
var selectCoorPrima=document.getElementById("coor_asigna_prima");

function rellena_contenedor_personal(){

    var idPersona=selectCoorPrima.value;
    var nombreCorreo= selectCoorPrima.options[selectCoorPrima.selectedIndex].text; //selectCoorPrima.text;

    //Crear elementos y adjuntarlos.
    var tbody=document.getElementById("lista_pp");
    var table_contenedor=document.getElementById("tabla_contenedor_p");

    var validador=new Array();

    for(var i=0; i<table_contenedor.rows.length; i++){

        var identificador_fila=table_contenedor.rows[i];
        var id_persona_fila=identificador_fila.getAttribute("id_persona_fila");

        if(i>0){
            validador.push(id_persona_fila);
        }
    }

    console.log(validador);

    if(validador.includes(idPersona)){
        alert("La cuenta se encentra en la lista");
    } else{
        
        var filaT=document.createElement("tr");
        var id_fila=document.createAttribute("id_persona_fila");
        id_fila.value=idPersona;
        filaT.setAttributeNode(id_fila);

        var columnaCheck=document.createElement("td");
        var columnaCorreo=document.createElement("td");
        var columnaEliminar=document.createElement("td");

        var ahref=document.createElement("a");
        ahref.href="javascript: void(0)";
        ahref.textContent="X";

        columnaCorreo.textContent=nombreCorreo;
        //columnaEliminar.textContent

        var checkb=document.createElement("input");
        checkb.type="checkbox";
        checkb.name="coor_selected[]";
        checkb.value=idPersona;
        checkb.checked=true;
        checkb.disabled=true;

        columnaCheck.appendChild(checkb);
        columnaEliminar.appendChild(ahref);
                
        filaT.appendChild(columnaCheck); //+columnaCorreo+columnaEliminar
        filaT.appendChild(columnaCorreo);
        filaT.appendChild(columnaEliminar);
        tbody.appendChild(filaT);
    }
}

//rellena_contenedor_personal
selectCoorPrima.addEventListener("change",rellena_contenedor_personal);

//----------------------------------------------------------------------
function asigna_meta_por_ramo(e){

    e.preventDefault(); 

    //formulario=document.getElementById("formulario_asigna_meta");
    var ramos=["autos","vida","gmm","danios","fianzas"];
    var coor_asignados=document.getElementsByName("coor_selected[]");

    var agentes=crear_array_envio(coor_asignados);
    var datos_asignados=crear_objeto_envio(ramos);
    var mes_dom=document.getElementById("mes_asignado");
    var mes_selecionado=mes_dom.options[mes_dom.selectedIndex].value;
    var send_data={};

    for(var i=0; i<agentes.length; i++){
        
        send_data[agentes[i]]={
            [mes_selecionado]:{
                datos_asignados
            }
        }
    }

    //console.log(send_data);

    //---------------------------------------
    //Envio de solicitud por AJAX

    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            console.log(JSON.parse(this.responseText));

        }
    };

    xmlhttp.open("POST", direccion+"/meta_por_ramo",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("send="+JSON.stringify(send_data));
    //---------------------------------------
}
//----------------------------------------------------------------------
function crear_array_envio(dom_element){

    var recabado=[];
    //var recabado={};

    for(var i=0; i<dom_element.length; i++){

        //if(dom_element[i].type=="checkbox" && dom_element[i].checked){

            //recabado["coordinador"]=dom_element[i].value;
            recabado.push(dom_element[i].value);
        //} else {

        //}

    }

    return recabado;
}
//-------------------------------------------------------------------
function crear_objeto_envio(array_data){

    var info_contenedor={};

    for(var i=0; i<array_data.length; i++){

        var recabado={};
        recabado["prima"]=document.getElementById(array_data[i]+"_prima").value;
        recabado["cantidad_polizas"]=document.getElementById(array_data[i]+"_polizas").value;

        info_contenedor[array_data[i]]=recabado;
    }

    return info_contenedor;

}
//-------------------------------------------------------------------
var submit_info_ramos=document.getElementById("boton_envia_ramos");

submit_info_ramos.addEventListener("click",asigna_meta_por_ramo);

//----------------------------------------------------------------------
/*if(selectCoordinacion.value==0){
    console.log(selectCoordinacion.value);
}*/